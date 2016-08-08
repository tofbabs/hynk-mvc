<?php
/**
 * Company Model
**/

class Category extends CacheModel {
	
    protected static $tableName = 'Category';
    protected static $primaryKey = 'category_id'; 
    
    function setId($value){
        $this->setColumnValue('category_id', $value);
    }
    function getId(){
        return $this->getColumnValue('category_id');
    }
    
    function setCatName($value){
        $this->setColumnValue('category_name', $value);
    }
    function getCatName(){
        return $this->getColumnValue('category_name');
    }
    
    function setCatDesc($value){
        $this->setColumnValue('category_description', $value);
    }
    function getCatDesc(){
        return $this->getColumnValue('category_description');
    }

    /*
    **  @desc Getter/Setter for Last Set Downloaded
    */
    function setCreator($value){
        $this->setColumnValue('created_by', $value);
    }
    function getCreator(){
        return $this->getColumnValue('created_by');
    }
    
}
