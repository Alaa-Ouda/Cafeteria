<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = "categories";
    function addCategory($data){

        return $this->insert($data);
    }
    function  deleteCategory($id){
        return $this->update(array('is_deleted' => 1), "cat_id=" . $id);
        
    }
    function getCategoryById($id){
        return $this->find($id)->toArray();
        
    }
    function editCategory($data){
        
        return $this->update($data, "pid=".$data['pid']);
        
    }
    function listCategories()
    {
        return $this->fetchAll()->toArray();
    }

}

