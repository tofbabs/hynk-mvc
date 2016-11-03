<?php

/**
 * DNCList Model Class
 * @extend ParentList Class
 */
include_once 'ParentList.class.php';

class PartialDNDList extends ParentList {
	
	protected static $tableName = 'partial_dnd';
    protected static $primaryKey = 'id';
    protected static $list_type = 'partial_dnd';

    function setListType($value='dnc'){
        # code...
        $this->setColumnValue('list_type', $value);
    }

    static function writeListCategoryToFile($file,$category){

        $query = "SELECT DISTINCT(msisdn) FROM ". static::$tableName ." WHERE category <> " . $category;
        $query .= " AND status = '1' INTO OUTFILE '" . $file . "' LINES TERMINATED BY '\r\n'";

        Utils::trace($query);

        $db = Database::getInstance();
        $s = $db->getPreparedStatment($query);

        // Check if any error during query
        if (!$s) {
            error_log("PDO::errorInfo(): " . var_export($dbh->errorInfo()));
            return FALSE;
        }

        $s->execute();
        return TRUE;
        
    }

}
