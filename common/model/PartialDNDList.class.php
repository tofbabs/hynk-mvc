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

}
