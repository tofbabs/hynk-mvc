<?php
header('Content-Type: text/plain');

/**
 * Site Index Controller
 */
global $host;

class ApiController extends Controller {

	private $host;
    
	function __construct() {
		$this->template = new Template();
        $this->setVariable('title', substr($this->getPageTitle(),0,-10));

        // Default: Disable HTTP Basic Authentication
        $this->check = Utils::checkAccess();
        $this->setView('', 'raw');

    }

    /*
        Get list of Blacklisted Numbers @$value=NULL
        Get a SIGNAL variable for a particular MSISDN e.g @$value=23480..
        Resp: 2000
    */

    function index(){
        $this->setHttpHeader(400, "BAD Request. Kindly Refer to Documentation");
    }

    function fetchRecent($list_type='dnd'){

         $this->setView('', 'raw');

                   // Enable HTTP Basic Authentication
         // $this->check = Utils::checkAccess(null,null,TRUE);
         $this->check = Utils::checkAccess();


         if ($this->check) {

            // Check if $list_type is DND or DNC display error 
             if(strtolower($list_type) == 'dnd' ||  strtolower($list_type) == 'dnc'){

                 $u = User::getOne(array('user_email' => $_SERVER['PHP_AUTH_USER']));
                 $company = Company::getOne(array('company_id' => $u->getCompany()));

                 $user_last_set_id = $company->getLastDownloadSet($list_type);

                 // Recent list buffer to download for user
                 $list = '';

                 $to_implement = Set::getUpdate($list_type, $user_last_set_id);
                 $all_set = implode(',',$to_implement);

                 if(!empty($to_implement)){

                     # get difference from the last time user implemented blacklist
                     foreach ($to_implement as $key => $i) {

                         $tmp_file = FILE_PATH . $i . '.csv';

                         if(file_exists($tmp_file)) {
                             $l = file_get_contents($tmp_file);
                             if ($l === false) $this->setHttpHeader(500, 'Something went wrong. Please try again later');

                             $list .= $l;
                         }
                     }

                     $company->setLastDownloadSet(end($to_implement), $list_type);
                     $company->save();

                     Activity::create('implement', $company->getName(), ' ' . ucfirst($list_type). ' Set' . $all_set);
                     echo $list;

                 }else{
                     $this->setHttpHeader(202, 'All recent blacklist has been implemented');
                 }

             }else{
                 $this->setHttpHeader(400, "BAD Request. Kindly Refer to Documentation");
             }
         }
         else {
             $this->setHttpHeader(403, 'Invalid User Information.');
         }

    }

    function fetchAllBlacklist($list_type='dnd'){

        $this->setView('', 'raw');
        // Enable HTTP Basic Authentication
        // $this->check = Utils::checkAccess(null,null,TRUE);
        $this->check = Utils::checkAccess();


        if ($this->check) {

            $l = FILE_PATH . $list_type . '.csv';

            if(!file_exists($l)){
                Utils::trace('File Cache not exist, May take longer to finish.');
                $listModel =  $list_type=='dnd' ? 'DNDList' : 'DNCList';
                $listModel::writeListToFile($l);
            }

            $list = @file_get_contents($l);
            if ($list === false){
                $this->setHttpHeader(500, 'Something went wrong. Please try again later');
            }

            $u = User::getOne(array('user_email' => $_SERVER['PHP_AUTH_USER']));
            $company = Company::getOne(array('company_id' => $u->getCompany()));

            if ($company->getId() != NULL) {
                // Activity Log
                Activity::create('implement', $company->getName(), 'All ' . strtoupper($list_type));
            }

            echo $list;

        } else {
            $this->setHttpHeader(403, 'Invalid User Information');
        }

    }

    function fetchAllDNC(){
        $this->fetchAllBlacklist('dnc');
    }

    function deleteUser($email){

        $u = User::getOne(array('user_email' => $email));
        if ($u->getId() != NULL) {
            # code...
            $u->delete();
            echo 'successful';
            $this->setVariable('response', '200:User Deleted');
        }else{
            $this->setVariable('response', '401:User Doesn\'t exist');
        }
    }

    // To be improved - 
    function get($_msisdn=NULL){

        $this->check = Utils::checkAccess(null,null,TRUE);

        if (isset($_msisdn)){

            $b = Blacklist::getOne(array('msisdn' => $_msisdn));
            $this->setVariable('response', $b->getId() != null ? '200:Number Exist in Blacklist' : '204:Number not in Blacklist');

        }

    }

    function search($msisdn){

        $this->check = Utils::checkAccess();

        if (isset($_GET['search'])) {
            # code...
            $msisdn = $_GET['search'];
        }

        $resp = 0;
        $result = Utils::trimMsisdn($msisdn);
        $msisdn = explode(':', $result);

        if ($msisdn[0] == 200) {
            # code...
            $b = @file_get_contents('http://localhost:9200/dnd/_search?q=' . $msisdn[1]);
            // print_r($b);
            $json_b = json_decode($b);
            if($json_b->hits->total == 0) {
                $this->setHttpHeader(202, 'Subscriber Not Blacklisted');
            }elseif($json_b->hits->total == 1){
                $this->setHttpHeader(200, 'Number Exist in Blacklist');
            }else{
                $this->setHttpHeader(500, 'Something went wrong. Please try again later');
            }

        }else{
            $this->setHttpHeader(400, "BAD MSISDN. Kindly check");
        }

    }

    /*
    *   Set HTTP Header 
    */

    function setHttpHeader($code, $msg){
        header("HTTP/1.0 ".$code.":" . $msg);
        echo $code.":" . $msg;
        die();
    }


    /*
    **  @last=NULL Fetches last 10 Activity
    **  e.g. @last=2 Fetches last 10 setting Starting Point of Dataset to variable
    */

    function activity($last = NULL){

        $count = Activity::getCount();
        $startIndex = 0;
        if(!is_null($last)){
            $startIndex = $last; 
        }
        $a = Activity::getAll(array(), "timestamp DESC",$startIndex, 10);

        $toJson = array();
        foreach ($a as $event) {
            # code...
            $af = new ActivityFrame();
            $af->id = $event->getId();
            $af->action = $event->getAction();
            $af->actor = $event->getActor();
            $af->object = $event->getObject();
            $af->timestamp = $event->getTimestamp();

            $c = Company::getOne(array('company_name' => $event->getActor()));

            // $af->url = $GLOBALS['host'] . "/user/profile/" .str_replace(' ', '-', $event->getActor());

            $af->url = $GLOBALS['host'] . "/user/profile/" .$c->getId();

            $toJson[] = $af;
        }

        echo json_encode($toJson);
    }

    function report(){

        $today = date('Y-m-d');
        $s = Set::get('SELECT * FROM UpdateSet WHERE createdon>"' . $today . '"');
        // print_r($s);

        $resp = array();
        foreach ($s as $key => $set) {
            # code...
            $a = array(strtotime($set->getTime()) . '000', $set->getListSize() );
            array_push($resp, $a );
        }
        // $r = array(
        //     array('1364598000000','2134'),
        //     array('1364619600000','5133'),
        //     array('1364641200000', '8195'),
        //     array('1364662800000','2134'),
        //     array('1364684400000','5133')
        // );
        echo json_encode($resp);

    }

    function __destruct(){
        $this->setVariable('check', $this->check);
    }

}

Class ActivityFrame{
    public $id;
    public $action;
    public $actor;
    public $object;
    public $timestamp;
    public $url;
}

?>