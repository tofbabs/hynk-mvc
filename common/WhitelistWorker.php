<?php

	ini_set('memory_limit', '-1');
	error_reporting(0);

	require '../system/config/config.php';
	require BASE_PATH . 'common/Utils.class.php';
	require BASE_PATH . 'lib/Database.class.php';
	require BASE_PATH . 'lib/Model.class.php';
	require BASE_PATH . 'lib/CacheModel.class.php';
	require BASE_PATH . 'common/model/ParentList.class.php';
	require BASE_PATH . 'common/model/Blacklist.class.php';
	require BASE_PATH . 'common/model/Activity.class.php';
	require BASE_PATH . 'common/model/Company.class.php';
	require BASE_PATH . 'common/model/User.class.php';
	require BASE_PATH . 'common/model/DNCList.class.php';

	$worker = new GearmanWorker();
	$worker->addServer();
	$worker->addFunction("process_whitelist_file", "whitelist_file");
	while ($worker->work());

	function whitelist_file($job){

		$workload = json_decode($job->workload());

		//Setup database
		Database::getInstance('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);

		if ($workload->type == 'file')
			$uploadedCSVArray = preg_split("/[\s|,]/", file_get_contents(BASE_PATH.'public/' . $workload->file));
		else
			$uploadedCSVArray = preg_split("/[\s|,]/", $workload->file);

	  $uploadedMSISDN = array();

		if ( ! empty($uploadedCSVArray)) {

		  foreach($uploadedCSVArray as $s) {
				$msisdn = filter_var($s, FILTER_SANITIZE_NUMBER_INT);
				$msisdn = substr($s, -10);
				if(strlen($msisdn) < 10)
					continue;
				$uploadedMSISDN[] = $msisdn;
			}

			//Delete entries from DB
			Blacklist::deleteBulk('list', 'msisdn', $uploadedMSISDN);

			//Delete from file.
			$list_type = 'dnd'; //hard coded

			$temp = '/tmp/' . $list_type . time() .'.csv';

			Blacklist::writeListToFile($temp);
			$blacklist = file_get_contents($temp);

			file_put_contents(FILE_PATH . $list_type. '.csv' , $blacklist);

			$companies = Company::getAll(array('company_role'=> '3'));
			$companyUsersMapping = array();

			$index = 0;

			foreach ($companies as $company) {
				$u = User::getAll(array('user_company_id' => $company->getId()));
				$companyUsersMapping[$index]['users'] = $u;
				$companyUsersMapping[$index]['name'] = $company->getName();
				$index++;
			}

			$set_info = array(date('Y-m-d'), count($uploadedMSISDN));

			if ( ! empty($companyUsersMapping))
				Utils::doBroadcast($companyUsersMapping, $set_info, 'Whitelist');

			$log = new Activity('notify','System','All Providers' . $set_info);
			$log->save();
		}
	}

?>
