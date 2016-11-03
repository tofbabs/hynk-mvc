<?php

/**
 * Blacklist Model Class
 * @extend ParentList Class
 */
include_once 'ParentList.class.php';

class DNDList extends ParentList {
	
    protected static $tableName = 'list';
    protected static $primaryKey = 'id';
    protected static $list_type = 'blacklist';

    function setListType($value='blacklist'){
        # code...
        $this->setColumnValue('list_type', $this->list_type);
    }

    
}
