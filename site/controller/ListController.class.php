<?php
global $host;
/**
 * Site Index Controller
 */

class ListController extends Controller {

    protected $u;
    protected $list_type;

    function __construct($_list_type='blacklist') {
        parent::__construct();

        $this->list_type = $_list_type;
        // Redirect User to Login page if not logged in
        if(!isset($_SESSION['company'])){
            $this->setView('', 'login');
            exit();
        }

        // Utils::printOut($this->list_type);
        $this->setVariable('title', $this->list_type);
        $this->u = $_SESSION['company'];
    }
    
    function index(){

        $listModel = $this->_checkList($this->list_type);
        $b = $listModel::getAll(array(), 'id DESC', 0 , 1000);
        
        $this->setVariable('blacklist', $b);
        $this->setVariable('isSingle', FALSE);
        $this->setView('', 'list');
    }

    /**  
     * Views All Approved List
     * @param NULL
     * @return NULL
     */ 

    function view(){
        $this->index();
    }


    /**  
     * History of all list updated on Site
     * @param set_id New upload Set ID.
     * @return listModel
     */ 

    function _checkList($type){

        $listModel = 'Blacklist';
        if ($type === 'dnd') {
            # code...
            $listModel = 'DNDList';
        }
        if ($type === 'dnc') {
            # code...
            $listModel = 'DNCList';
        }
        if ($type === 'partialdnd') {
            # code...
            $listModel = 'PartialDNDList';
        }

        return $listModel;

    }

    /**  
     * Adds sinlgle entries from Textbox to the List DB (Blacklist or DNC)
     * @param set_id New upload Set ID.
     * @return NULL
     */ 

    function single(){

        $this->privRoles = array(1,2);

        if ($this->list_type == 'partialdnd') {
            # code...
            $cat = Category::getAll();
            $this->setVariable('categories', $cat);
        }
        

        $this->setView('', 'single');
        $this->setVariable('list-type',$this->list_type);

        if(isset($_POST['addSingleBtn'])) {

            // Get Classname for list model
            // $type = isset($_POST['type']) ? $_POST['type'] : 'blacklist';
            $listModel = $this->_checkList($this->list_type);

            // Iniitalize the List Model
            $newList = new $listModel();
            $newList->setAccumulator($_SESSION['company']->getName());

            // Incase of multiple number input, converts string to array
            $msisdn = explode(',', $_POST['msisdn']);
            $msisdnCount = count($msisdn);

            $comment = $_POST['comment'];
            // Set Comment for the pending update set
            // Status is auto set to 0
            $newList->setComment($comment);


            # code...
            $category = isset($_POST['category']) ? $_POST['category'] : NULL;
            $newList->setCategory($category);

            // Counter for Good and Bad msisdn
            $badCount = $goodCount = $dupCount = 0;
            foreach ($msisdn as $value) {
                # validate MSISDN
                $value = Utils::trimMsisdn($value);
                // echo "Return Value from MSISDN trim utility: " . $value;
                $m = explode(':', $value);

                if ($m[0] == 500) {
                    # add to badCount
                    $badCount++;
                }

                if ($m[0] == 200) {
                    # code...
                    // Save newList Object for every good msisdn parsed
                    $newList->setMsisdn($m[1]);
                    $inf = $newList->save(); 
                    // echo "Database INfo: " . $inf;
                    $arr_inf = explode(':', $inf);
                    if ($arr_inf[0] != 201) {
                        # code...
                        Activity::create('add-list', $_SESSION['company']->getName() , $msisdnCount);
                        $goodCount++;
                    }else{
                        $dupCount++;   
                    }

                }

            }

            Utils::trace('Updating '.ucfirst($this->list_type).' File...');

            if (isset($dupCount) && $dupCount != 0){
                $this->notifyBar('info',  $dupCount . ' duplicate msisdn added to '.ucfirst($this->list_type));
            }

            if (isset($goodCount) && $goodCount != 0){
                $this->notifyBar('success',  $goodCount . ' msisdn added to '.ucfirst($this->list_type)); 
            }

            if(isset($badCount) && $badCount != 0){
                $this->notifyBar('error',  $badCount . ' invalid msisdn not added to '.ucfirst($this->list_type));
            }
        }
        
    }

    /**  
     * @desc Adds Bulk Entry from Uploaded File to the List DB (Blacklist or DNC)
     * Runs as a Gearman Client to execute file processing at the background 
     * @param set_id New upload Set ID.
     * @return NULL
     */ 

    function bulk(){

        $this->privRoles = array(1,2);

        if ($this->list_type == 'partialdnd') {

            $cat = Category::getAll();
            $this->setVariable('categories', $cat);
        }

        $this->setView('', 'bulk');
        $this->setVariable('list-type',$this->list_type);

        if(isset($_POST['addBulkListBtn'])) {

            $uploadfile = TEMP_UPLOAD_PATH . $this->u->getName() . time() . '.csv';
            Utils::printOut("Uplaod File PATH: " . $uploadfile);
            Utils::printOut($_FILES);

            $resp = array();

            // Get Classname for list model
            // $type = isset($_POST['type']) ? $_POST['type'] : 'blacklist';
            $listModel = $this->_checkList($this->list_type);

            // Remove all whitespace character from uploadfile name
            $uploadfile = str_replace(' ','_',$uploadfile);

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

                $this->notifyBar('success','Upload Successful');
                $category = isset($_POST['category']) ? $_POST['category'] : NULL;

                try {
                    // send processing to gearman
                    $client = new GearmanClient();
                    $client->addServer();

                    // store the gearman handle and send the task to the background
                    // Run Process in Background
                    $jobHandle = $client->doBackground("process_file", json_encode(array(
                       // whatever details you gathered from the form
                      'file' => $uploadfile,
                      'user' => $_SESSION['company']->getName(),
                      'category' => $category,
                      'comment' => $_POST['comment'],
                      'listModel' => $listModel
                      )));

                    // $jobHandle = $client->doBackground("process_file", $uploadfile);
                    
                    $resp["msg"] = "File Processing...";
                    $resp["handle"] = $jobHandle;

                    if ($client->returnCode() != GEARMAN_SUCCESS) throw new Exception("Could not add the job to the queue.", 1);

                } catch(Exception $e) {
                    // some error handling
                    $resp["msg"] = "There occured a strange error.";
                    $resp["error"] = true;

                    // Display Response
                    if(isset($resp['error']) && $resp['error']){
                        $this->notifyBar('error',$resp['msg']);
                    }
                } 
                // finally{
                $_SESSION['FILE_PROCESSING'] = $resp;
                // }
            } 
            else {
             $this->notifyBar('error','Upload Failed');
             exit();
         }
     }

     if(isset($_SESSION['FILE_PROCESSING']["handle"])){
        $livejobhandle = $_SESSION['FILE_PROCESSING']["handle"];
        $status = json_decode($this->file_status($livejobhandle),true);
            // print_r($status);
        if (isset($status['percentage']) && $status['percentage'] == 0) {
            $this->notifyBar('info',ucfirst($this->list_type).' Update Processing...');
        }
    }else{
        $this->notifyBar('info','No '.ucfirst($this->list_type).' Update in Progress. Create New');
    }

}

function approve($msisdn=NULL){

    $this->privRoles = array(1);
    $this->setView('', 'pending');

    $listModel = $this->_checkList($this->list_type);

        // Get Count of Unapproved blacklist
    $count = $listModel::getCount(array('status' => 0));

        // Get the Last 1000 updated blacklist
    $b = $listModel::getAll(array('status' => 0), 'id DESC', 0,1000);

        # From API
    if(isset($msisdn)) {
        $singleb = $listModel::getOne(array('msisdn' => $msisdn));
        $singleb->setStatus(1);
        $singleb->save();
        $this->index();
            // Refresh Temp memory of blacklisted numbers
            // $b = Blacklist::getAll(array('status' => 0), 'id DESC');
        exit();
    }        

        // If User Clicks Approve Button, Change Status of Blacklist and Notify Providers
    if(isset($_POST['approveBtn'])) {

        $admin_comment = Utils::sanitize($_POST['comment']);

            // If count of Unapproved Blacklist = 0, Show Previous list with warning
        if ($count == 0) {
                # code...\
            $this->notifyBar('info', 'There are no pending '.ucfirst($this->list_type));
            $this->index();
            exit;
        }

        $newSet = new Set();
        $newSet->setComment($admin_comment);
        $newSet->setListSize($count);
        $newSet->setListType($this->list_type);
        $newSet->setUser($_SESSION['company']->getName());
        $newSet->save();

        $user_last_set_id = $this->u->getLastDownloadSet($this->list_type);
        // Get Newly Created SET ID
        $to_implement = Set::getUpdate($this->list_type, $user_last_set_id);
        $last = end($to_implement);
        // $last = Set::getLast();

        // Update status of unapproved blacklist and assigned to last set id
        
        $status = $listModel::updateStatus($last);
        
        if ($status == 200) {
            # code...
            $set_info = $newSet->getTime() . "+" . $newSet->getListSize();
            $this->doBroadCast($admin_comment, $set_info);

            // Activity Log
            Activity::create('approve',$_SESSION['company']->getName(),'Set ' . $newSet->getId() . ' - ' . $newSet->getListSize());

            // Create Updated File for download
            $this->createBlacklistFile($last);

        } else $this->notifyBar('error', 'Something went wrong..Please try again ');

        // Show all Blacklist
        $this->index();
        

    }

    if (empty($b)) {
            # code...
       $this->notifyBar('info', 'There are no pending '.ucfirst($this->list_type));
       $this->index();

   } else{
    $this->setVariable('header_info', $count . ' Pending '.ucfirst($this->list_type).' Request');
    $this->setVariable('blacklist', $b);
    $this->setView('', 'pending');
}



}

    /**  
     * History of all list updated on Site
     * @param set_id New upload Set ID.
     * @return NULL
     */ 

    function history($page = NULL){
        # code...
        $page = isset($page) ? $page : 1;

        $s = Set::getAll(array('list_type' => $this->list_type), 'id DESC', ($page-1)*10, 10);

        $this->setVariable('set', $s);
        $this->setVariable('current', $page);
        $this->setVariable('total', Set::getCount(array('list_type' => $this->list_type)) );

        $type = $this->list_type=='dnc' ? 'dnc' : 'list';
        $this->setVariable('type', $type);
        $this->setView('', 'history');        
    }


    function doBroadcast($comment=NULL, $set_info=NULL){

        if (is_null($comment) || is_null($set_info)) {
            # code...
            $this->setView('', '404');
            exit();
        }

        $info = explode("+", $set_info);

        $subject = "NEW UPDATE: ".ucfirst($this->list_type)." MSISDN";

        $c = Company::getAll(array('company_role'=> '3'));
        foreach ($c as $company) {
            # code...
            $u = User::getAll(array('user_company_id' => $company->getId()));

            foreach ($u as $user) {
                # code...
                $to = $user->getEmail();
                $msg = "Hello " . $company->getName() . PHP_EOL;
                $msg .= "Kindly log on to the Blacklisting Portal (http://blacklist.atp-sevas.com/blacklist) to download the latest ". ucfirst($this->list_type) . " update file." . PHP_EOL;
                // $msg .= "You can also implement by invoking an API with endpoint http://blacklist.atp-sevas.com/blacklist/api/fetchAll".ucfirst($this->list_type)." and providing your email and password for HTTP Basic Authentication." . PHP_EOL;
                $msg .= "You can also implement by downloading the entire list on this dropbox file https://goo.gl/5UhXby" . PHP_EOL;
                $msg .= "Latest Update time: " . $info[0] . PHP_EOL;
                $msg .= "Additional MSISDN Count: " . $info[1];

                //Push to Gearman to Send Email;
                Utils::sendmail($to, $subject, $msg, EMAIL_HEADER);
            }
            
        } 
        
        // Activity Log
        $log = new Activity('notify','System','All Providers' . $set_info);
        $log->save();

    }

    function search($_msisdn=NULL){

        $listModel = $this->_checkList($this->list_type);

        $this->setVariable('isSingle', 'TRUE');
        $this->setVariable('notFound','TRUE');

        if (isset($_POST['searchBtn'])) {
            $_msisdn = Utils::trimMsisdn($_POST['msisdn']);
            $this->setVariable('msisdn', explode(':',$_msisdn)[1]);

            $result = $listModel::getOne(array('msisdn' => $_msisdn));

            $arrResult = array($result);
            Utils::trace('Search Result for ' . $_msisdn . ' returns ' );

            if (!empty($arrResult)) {
                    # code...
                $this->setVariable('notFound','FALSE');
                $this->setVariable('blacklist', $arrResult);
                $this->setView('', 'list');
            }
        }else{
            $this->notifyBar('error', $_POST['msisdn'] . " Not Found");
            $this->setView('', 'list');
        }



    }

    function delete($value){
        $this->privRoles = array(1);
        $this->setView('', 'list');

        $listModel = $this->_checkList($this->list_type);

        if (!isset($value)) {
            # code...
            exit();
        }
        $singleb = $listModel::getOne(array('msisdn' => $value));
        $singleb->delete();
        $this->notifyBar('success', $value . " Successfully Removed From ".ucfirst($this->list_type));

        $log = new Activity('delete',$_SESSION['company']->getName(),$value);
        $log->save();

        $this->index('', 'list');


    }

    /**  
     * Filters Uploaded Base with Blacklist
     * @param set_id New upload Set ID.
     * @return NULL
     */ 

    function filter(){

        if(isset($_POST['fileFilterBtn'])) {

            $uploadfile = UPLOAD_PATH . $this->u->getName() . "_dirty_" . time();
            
            // Gearman Response Buffer Variable
            $resp = '';

            // Remove all whitespace character from uploadfile name
            $uploadfile = str_replace(' ','_',$uploadfile);

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

                $this->notifyBar('success','Upload Successful');

                try {
                    // send processing to gearman
                    $client = new GearmanClient();
                    $client->addServer();

                    // store the gearman handle and send the task to the background
                    // Run Process in Background
                    $jobHandle = $client->doBackground("process_filter_file", json_encode(array(
                       // whatever details you gathered from the form
                      'file' => $uploadfile,
                      'user_name' => $this->u->getCompany(),
                      'user_email' => $this->u->getEmail(),
                      'type' => 'file'
                      )));

                    // $jobHandle = $client->doBackground("process_file", $uploadfile);
                    
                    $resp["msg"] = "File Processing...";
                    $resp["handle"] = $jobHandle;

                    if ($client->returnCode() != GEARMAN_SUCCESS) throw new Exception("Could not add the job to the queue.", 1);

                } catch(Exception $e) {
                    // some error handling
                    $resp["msg"] = "There occured a strange error.";
                    $resp["error"] = true;
                } 
                // finally {
                    // Display Response
                if(isset($resp['error']) && $resp['error']){
                    $this->notifyBar('error',$resp['msg']);
                }

                $_SESSION['FILE_PROCESSING'] = $resp;

                // }

            } 
            else {
             $this->notifyBar('error','Upload Failed');
             exit();
         }

            // $this->setVariable('link', $GLOBALS['host']  ."/site/files/". $name);

     }

     if(isset($_POST['screenFilterBtn'])) {

        $api = new ApiController();
        $dirtyArr = explode(PHP_EOL, $_POST['dirty']);
        if(strlen($dirtyArr[0]) > 14){
         $dirtyArr = explode(",", $dirtyArr[0]); 
     }

            // $dirtyArr = explode(",", $_POST['dirty']);

     $name = $_SESSION['company']->getName() . "_clean_from_screen_" . time() . ".csv";
     $filtered = FILE_PATH . $name;

     $cleanArr = array();
     foreach ($dirtyArr as $msisdn) {
                # code...
        if($api->search($msisdn) == 0){
            $cleanArr[]=$msisdn;
                    // file_put_contents($filtered, $msisdn, FILE_APPEND);
        } 

    }
    $this->setVariable('clean', $cleanArr);
            // print_r($cleanArr);
            // Notification Filter Number of msisdn

    $this->setVariable('link', $GLOBALS['host'] ."/public/". $filtered . "/");

    $log = new Activity('filter',$_SESSION['company']->getName() , 'Filtering ' . count($dirtyArr) . ' MSISDNs');
    $log->save();

}

$this->setView('', 'filter');

}

    /**  
     * Checks File Upload Status
     * @param jobHandle
     * @return json status
     */ 

    function file_status($jobHandle){

        $resp = array();
        try {
            // ask for job status
            $client = new GearmanClient();
            $client->addServer();
            $stat = $client->jobStatus($jobHandle);
            // print_r($stat);
            if (!$stat[0]) { // it is done
                $resp["msg"] = "Transfer completed.";
            } else {
                $resp["msg"] = "Transfer in progress.";
                $w = (float)$stat[2]; // calculate the percentage
                $g = (float)$stat[3];
                $p = ($g>0)?$w/g*100:0;
                $resp["percentage"] = $p;
            }
        } catch(Exception $e) {
                // some error handling
            $resp["msg"] = "There occured a strange error.";
            $resp["error"] = true;
        } 
        // finally {
        return (json_encode($resp));    
        // }
    }

    /**  
     * Downloads all blacklist and updates the Activity Table.
     * @param set_id New upload Set ID.
     * @return NULL
     */ 

    function createBlacklistFile($set_id=NULL){

        $listModel = $this->_checkList($this->list_type);

        // Recreates the whole List file
        $temp = '/tmp/' . $this->list_type . time() .'.csv';

        $listModel::writeListToFile($temp);
        $blacklist = file_get_contents($temp);

        Utils::trace('Updating Cache Base ' . FILE_PATH . $this->list_type.'.csv');
        file_put_contents(FILE_PATH . $this->list_type. '.csv' , $blacklist);

        // Create file for Particular Set Uploaded
        if (isset($set_id)) {
            # code...
            $new_set_file = FILE_PATH . $set_id .'.csv';
            $listModel::writeListToFile($new_set_file, $set_id);
        }

        $this->notifyBar('info','Entire '.strtoupper($this->list_type).' Cache File Regenerated');
        $this->view();
        

    }

    /**  
     * Downloads Most Recent List for the particular 
     * User account Logged in and Updates the Activity Table.
     * @param 
     * @return NULL
     */ 

    function download_recent(){

        if ($this->list_type == 'partialdnd') {
            # code...
            $this->view();
            exit;
        }

        $user_last_set_id = $this->u->getLastDownloadSet($this->list_type);
        $listModel = $this->_checkList($this->list_type);

        // Recent list buffer to download for user
        $list = '';

        // $last = Set::getLast($this->list_type);
        $to_implement = Set::getUpdate($this->list_type, $user_last_set_id);
        $all_set = implode(',',$to_implement);


        // if ($user_last_set_id != $last) {
        if(!empty($to_implement)){
            # get difference from the last time user implemented blacklist

            // for ($i = $last; $i > $user_last_set_id; $i--) { 
            foreach ($to_implement as $key => $i) {
                # code...
                // $tmp_file = FILE_PATH . $this->list_type . '_set' . $i . '.csv';
                $tmp_file = FILE_PATH . $i . '.csv';
                // $all_set[]= $i;
                if(file_exists($tmp_file)) $list .= file_get_contents($tmp_file);
                // $list .= file_get_contents($tmp_file);
            }

            // Make file available for Download
            $filename = $this->list_type . '_SET_' . $last . '.txt' ;
            Utils::downloadFile($list,$filename);

            $this->u->setLastDownloadSet(end($to_implement), $this->list_type);
            $this->u->save();
            Activity::create('implement', $this->u->getName(), ' ' . ucfirst($this->list_type). ' Set' . implode(',', $all_set));

        }

        $msg = 'You have Downloaded the most recent update, Go to <a href="'.ROOT_URL.'/list/history">Approve History</a> to Download Set Again';
        $this->notifyBar('info', $msg);
        $this->view();

    }

    /**  
     * Downloads all blacklist and updates the Activity Table.
     * @param string this is a description of the first parameter
     * @param int this is a description of the second parameter
     * @return int this describes what the function returns
     */ 

    public function download_all(){

        $list = file_get_contents(FILE_PATH . $this->list_type .'.csv');
        $filename = $this->list_type . '_COMPLETE.txt';

        if (isset($list)) {
            # code...
            Activity::create('implement', $this->u->getName(), ' All '. ucfirst($this->list_type));
            Utils::downloadFile($list,$filename);
        }
        
    }


    /**  
     * Downloads all blacklist and updates the Activity Table.
     * @param set_id int Set ID user wish to download
     * @return NULL
     */ 

    public function download_set($set_id=NULL){

        $s = Set::getOne(array('id' => $set_id));

        // If set_id not specified download most recent for user
        if ($set_id == NULL) {
            # code...
            $this->download_recent();
            exit();
        }
        Utils::printOut($s);

        if ($s->getListSize() == NULL || $s->getListType() != $this->list_type) {
            # code...
            $this->notifyBar('info', 'No Set ' . $set_id . ' for ' . strtoupper($this->list_type));
            $this->history();
            exit();
        }

        $list = file_get_contents(FILE_PATH . $set_id . '.csv');
        $filename = $this->list_type . '_SET_' . $set_id . '.txt';
        if (isset($list)) {
            # code...
            Activity::create('implement', $this->u->getName(), ' ' .ucfirst($this->list_type).' Set' . $set_id);
            Utils::downloadFile($list, $filename);
            $msg = 'You have Downloaded Set '.$set_id.', Go to <a href="'.ROOT_URL. $this->list_type . '/history">Approve Set History</a>';   
            $this->view();
        }

        
    }

    /**  
     * CREATES/Regenerates ALL blacklist set cache file for Easy Access
     * @return NULL
     */ 

    public function generate_old_set(){

        $s = Set::getAll(array('list_type' => $this->list_type));
        $listModel = $this->_checkList($this->list_type);

        foreach ($s as $key => $set) {

            # Check if Set is particular list type
            // if ($set->getListType() !== $this->list_type) {
            //     # code...
            //     continue;
            // }

            $sid = $set->getId();
            $file = FILE_PATH . $sid . '.csv';

            // Remove existing instance of file
            if(file_exists($file))unlink($file);;

            // $this->createBlacklistFile($sid);
            $listModel::writeListToFile($file,$sid, $set->getListType());
        }
        $this->notifyBar('info','Set Cache File Regenerated');
        $this->view();
    }

    function __processDatabales(){

        $this->setView('','plain');
        define('MyTable', 'Blacklist');

        // print_r($_POST);

        /* IF Query comes from DataTables do the following */
        // if (!empty($_POST) ) {
        //     /* END DB Config and connection */
        //     // print_r($_POST);

        //     /* Useful $_POST Variables coming from the plugin */
        //     $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        //     $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
        //     $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
        //     $orderType = $_POST['order'][0]['dir']; // ASC or DESC
        //     $start  = $_POST["start"];//Paging first record indicator.
        //     $length = $_POST['length'];//Number of records that the table can display in the current draw
        //     /* END of POST variables */

        //     $sql = "SELECT * FROM ".MyTable;
        //     $data = $this->list_type == 'dnc' ? count(DNC::getData($sql)) : count(Blacklist::getData($sql));


        //     /* SEARCH CASE : Filtered data */
        //     if(!empty($_POST['search']['value'])){

        //         /* WHERE Clause for searching */
        //         for($i=0 ; $i<count($_POST['columns']);$i++){
        //             $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
        //             $where[]="$column like '%".$_POST['search']['value']."%'";
        //         }
        //         $where = "WHERE ".implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
        //         /* End WHERE */

        //         $sql = sprintf("SELECT * FROM %s %s", MyTable , $where);//Search query without limit clause (No pagination)

        //         // $recordsFiltered = count(getData($sql));//Count of search result
        //         $recordsFiltered = $this->list_type == 'dnc' ? count(DNC::getData($sql)) : count(Blacklist::getData($sql));

        //         /* SQL Query for search with limit and orderBy clauses*/
        //         $sql = sprintf("SELECT * FROM %s %s ORDER BY %s %s limit %d , %d ", MyTable , $where ,$orderBy, $orderType ,$start,$length  );
        //         $data = $this->list_type == 'dnc' ? DNC::getData($sql) : Blacklist::getData($sql);
        //     }
        //     /* END SEARCH */
        //     else {
        //         $sql = sprintf("SELECT * FROM %s ORDER BY %s %s limit %d , %d ", MyTable ,$orderBy,$orderType ,$start , $length);
        //         $data = $this->list_type == 'dnc' ? DNC::getData($sql) : Blacklist::getData($sql);

        //         $recordsFiltered = $recordsTotal;
        //     }

        //     /* Response to client before JSON encoding */
        //     $response = array(
        //         "draw" => intval($draw),
        //         "recordsTotal" => $recordsTotal,
        //         "recordsFiltered" => $recordsFiltered,
        //         "data" => $data
        //     );

        //     echo json_encode($response);
        //     // print_r(json_encode($response));

        // } else {
        //     echo "NO POST Query from DataTable";
        // }
    }

    function cat($cat_id=NULL){

        if(is_null($cat_id)){
            $this->index();
            exit();
        }

        $listModel = $this->_checkList($this->list_type);

        $b = $listModel::getAll(array('category' => $cat_id), 'id DESC', 0 , 1000 );
        $count = $listModel::getCount(array('category' => $cat_id));

        $this->setVariable('blacklist', $b);
        $this->setVariable('blacklist_count', $count);

        $this->setVariable('isSingle', FALSE);
        $this->setView('', 'list');

    }


    function _debugEMAIL(){

        Utils::sendmail('tofunmi@tm30.net','Testing','Is it working',EMAIL_HEADER);
        Utils::sendmail('tofbab002@yahoo.com','Testing','Is it working',EMAIL_HEADER);

    }

}

?>