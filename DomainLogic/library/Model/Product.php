<?php
/**
 * Product Model for first iteration with MVC
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class Model_Product extends Model_Abstract
{
    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        $this->_table = new Zend_Db_Table('product');
    }
    
    /**
     * Insert new record
     * 
     * @param array $data
     * @return integer
     */
    public function insert($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return parent::insert($data);
    }

    /**
     * Update table record
     *
     * @param array $data
     * @param string|array $where
     * @return integer
     */
    public function update($data, $where)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
    
}