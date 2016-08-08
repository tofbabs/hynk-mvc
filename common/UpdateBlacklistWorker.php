<?php

	include  '../system/config/config.php';
	require BASE_PATH . 'common/Utils.class.php';

	require BASE_PATH . 'lib/Database.class.php';
	require BASE_PATH . 'lib/Model.class.php';
	require BASE_PATH . 'lib/CacheModel.class.php';
	require BASE_PATH . 'common/model/ParentList.class.php';
	require BASE_PATH . 'common/model/Blacklist.class.php';
	require BASE_PATH . 'common/model/DNCList.class.php';
	
	$worker = new GearmanWorker();
	$worker->addServer();
	$worker->addFunction("process_file", "update_blacklist");
	while ($worker->work());	

	function update_blacklist($job){

		$workload = json_decode($job->workload());
		//Setup database
		Database::getInstance('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);

		$listModel = $workload->listModel;
		// $newList = new Blacklist();

		// Declare list Model
		$newList = new $listModel();
		var_export($newList);
		$newList->setAccumulator($workload->user);
		$newList->setComment($workload->comment);
		$newList->setCategory($workload->category);

		if (($handle = fopen($workload->file, "r")) !== FALSE) {

		    while (($data = fgetcsv($handle, 20, "\n")) !== FALSE) {

		    	$msisdn = substr(trim($data[0]), -10);
				$msisdn = filter_var($msisdn, FILTER_SANITIZE_NUMBER_INT);
		        // echo $msisdn;
		        if ($msisdn == '' || !is_numeric($msisdn)) {
		            # code...
					echo 'BAD INPUT' . $msisdn . PHP_EOL;

		            continue;
		        }
		        echo $msisdn . PHP_EOL;
		        $newList->setMsisdn($msisdn);
		        $newList->save();

		    }

		    fclose($handle);
		}

	}

?>
