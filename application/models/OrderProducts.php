<?php

class Application_Model_OrderProducts extends Zend_Db_Table_Abstract
{

    protected $_name="order_products";
    
    function addOrderProduct($data)
    {
        $this->insert($data);  
    }
}

