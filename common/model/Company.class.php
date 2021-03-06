<?php
/**
 * Company Model
**/

class Company extends Model {
	
    protected static $tableName = 'Company';
    protected static $primaryKey = 'company_id'; 
    
    function setId($value){
        $this->setColumnValue('company_id', $value);
    }
    function getId(){
        return $this->getColumnValue('company_id');
    }
    
    function setName($value){
        $this->setColumnValue('company_name', $value);
    }
    function getName(){
        return $this->getColumnValue('company_name');
    }
    
    function setPrivilege($value){
        $this->setColumnValue('company_role', $value);
    }
    function getPrivilege(){
        return $this->getColumnValue('company_role');
    }

    /*
    **  @desc Getter/Setter for Last Set Downloaded
    */
    function setLastDNDSet($value){
        $this->setColumnValue('last_dnd_set', $value);
    }

    function setLastDNCSet($value){
        $this->setColumnValue('last_dnc_set', $value);
    }

    function setLastDownloadSet($value, $type='DND'){
        $this->setColumnValue('last_'. strtolower($type) .'_set', $value);
    }


    function getLastDownloadSet($type){
        return $this->getColumnValue('last_'. strtolower($type) .'_set');
    }
    
}
