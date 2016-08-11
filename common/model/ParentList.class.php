<?php
/**
 * User Model
 */
class ParentList extends CacheModel {
	
    protected static $tableName = 'list';
    protected static $primaryKey = 'id';
    protected static $list_type;

    function __construct() {
        
        parent::__construct();
        $this->setColumnValue('list_type', static::$list_type);
    }

    // Id is auto set
    function getId(){
        return $this->getColumnValue('id');
    }
    
    function setMsisdn($value){
        if ($value) {
            # code...
        }
        $msisdn = substr($value, '-10');
        $this->setColumnValue('msisdn', $value);
    }
    function getMsisdn(){
        return $this->getColumnValue('msisdn');
    } 

    function setUploadSet($value){
        # code...
        $this->setColumnValue('upload_set', $value);
    }
    function getUploadSet(){
        return $this->getColumnValue('upload_set');
    } 

    // Update time is auto set
    function getUpdateTime(){
        return $this->getColumnValue('update_time');
    }

    function setAccumulator($value){
        $this->setColumnValue('accumulator_id', $value);
    }

    function getAccumulator(){
        return $this->getColumnValue('accumulator_id');
    }

    function setComment($value){
        # code...
        $this->setColumnValue('comment', $value);
    }
    function getComment(){
        return $this->getColumnValue('comment');
    }

    function setCategory($value){
        # code...
        $this->setColumnValue('category', $value);
    }
    function getCategory(){
        return $this->getColumnValue('category');
    }

    function setStatus($value){
        # code...
        $this->setColumnValue('status', $value);
    }
    function getStatus(){
        return $this->getColumnValue('status');
    }

    function setListType($value){
        # code...
        $this->setColumnValue('list_type', $value);
    }
    function getListType(){
        return $this->getColumnValue('list_type');
    }

    /**   
    *   @desc Overrides Model::getOne; SpeciFies List type in condition
    *   @param condition array reference
    *   @param order INT 
    *   @param startIndex INT
    *   @param count INT
    *   @return Multiple Object of corresponding Model
    **/

    public static function getAll($condition = array(), $order = NULL, $startIndex = NULL, $count = NULL){
        
        // Gets List Type and specify in condition
        $condition['list_type'] = static::$list_type;
        return parent::getAll($condition, $order, $startIndex, $count);

    }

    /**   
    *   @desc Overrides Model::getOne; SpeciFies List type in condition
    *   @param condition array reference
    *   @param order INT 
    *   @param startIndex INT
    *   @return One Object of corresponding Model
    **/

    public static function getOne($condition = array(), $order = NULL, $startIndex = NULL){
        
        // Gets List Type and specify in condition
        $condition['list_type'] = static::$list_type;
        return parent::getOne($condition, $order, $startIndex);
        
    }

    
    public static function getCount($condition = array()){
        
        // Gets List Type and specify in condition
        $condition['list_type'] = static::$list_type;
        return parent::getCount($condition);
        
    }
   

    static function getUnique($column='msisdn', $condition=array()){
        // Gets List Type and specify in condition
        $condition['list_type'] = static::$list_type;
        $query = "SELECT DISTINCT ". $column ." FROM " . static::$tableName;
        if(!empty($condition)){
            $query .= " WHERE ";
            foreach ($condition as $key => $value) {
                $query .= $key . "=:".$key." AND ";
            }
        }
        $query = rtrim($query,' AND ');
        return self::get($query,$condition);
    }

    static function updateStatus($value){
        $query = "UPDATE " . static::$tableName ." SET status=1, upload_set=" . $value ." WHERE status=0 ";
        $query .= "AND list_type = '". static::$list_type . "'";        

        Utils::printOut($query);
        $db = Database::getInstance();
        $s = $db->getPreparedStatment($query);

        // Check if any error during insert
        if (!$s) {
            error_log("PDO::errorInfo(): " . var_export($dbh->errorInfo()));
            return 500;
        }

        $s->execute();
        self::clearCache();
        return 200;
        
    }

    static function writeListToFile($file,$set_id=NULL, $type=NULL){

        $query = "SELECT DISTINCT(msisdn) FROM ". static::$tableName ." WHERE ";

        if (isset($set_id)) {
            # code...
            $query .= "upload_set=" . $set_id . " AND ";
        }
        if(isset($type)) $query .= "list_type = '". $type."' AND ";
        else $query .= "list_type = '". static::$list_type."' AND ";

        $query .= "status = '1' INTO OUTFILE '" . $file . "' LINES TERMINATED BY '\r\n'";
        Utils::trace($query);

        $db = Database::getInstance();
        $s = $db->getPreparedStatment($query);
        $s->execute();
        
    }

    static function getData($query){

        $db = Database::getInstance();

        $s = $db->getPreparedStatment($query);
        $s->execute();
        $result = $s->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result);
        return $result;

        // $query = mysqli_query($connection, $sql) OR DIE ("Can't get Data from DB , check your SQL Query " );
        // $data = array();
        // // print_r($query);
        // foreach ($query as $row ) {
        //     $data[] = $row ;
        // }

        // return $data;
    }


    /**
     * Get a single item
     */
    static function getDistinctCount($condition=array()){

        $data = count( @file( FILE_PATH . static::$list_type . '.csv'));
        return $data;


        // $redis = Cache::getInstance();
        // if ($redis == FALSE) {
        //     # code...
        //     $data = count( @file( FILE_PATH . static::$list_type . '.csv'));
        //     return $data;
        // }

        // $query_key = static::$tableName . '_' . static::$list_type . '_' . serialize($condition);
        // $check = $redis->get($query_key) == NULL  ? FALSE : TRUE;

        // if ($check){

        //     return unserialize($redis->get($query_key));

        // } else{

        //     $data = count( file( FILE_PATH . static::$list_type . '.csv'));
        //     self::clearCache($query_key);

        //     // id to column array mapping
        //     $redis->set($query_key, serialize($data));
        //     $redis->expire($query_key, 108000);

        //     return $data;
        // }
        
    }

    /*
    **  @desc Searchs Entire List for specified msisdn
    */
    static function searchEntire(){
    }

   
}
