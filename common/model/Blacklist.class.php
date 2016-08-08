<?php

/**
 * Blacklist Model Class
 * @extend ParentList Class
 */
include_once 'ParentList.class.php';

class Blacklist extends ParentList {
	
    protected static $primaryKey = 'id';
    protected static $list_type = 'blacklist';

    function setListType($value='blacklist'){
        # code...
        $this->setColumnValue('list_type', $this->list_type);
    }

    function getdatatablesList(){

    	$query = mysqli_query($connection, $sql) OR DIE ("Can't get Data from DB , check your SQL Query " );
    	$data = array();
    	// print_r($query);
    	foreach ($query as $row ) {
    	    $data[] = $row ;
    	}

	    return $data;
    }
}
