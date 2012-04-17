<?php
/**
 * Brand Model for first iteration with MVC
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class Model_Brand extends Model_Abstract
{
    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        $this->_table = new Zend_Db_Table('brand');
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
    
    /**
     * Get array of options for brand select element
     * 
     * @return array
     */
    public function getBrandOptions()
    {
        $select = $this->_table->getAdapter()->select();
        $select->from($this->_table->info(Zend_Db_Table::NAME), array('brand_id', 'name'));
        $stmt = $this->_table->getAdapter()->query($select);
        $data = $stmt->fetchAll(Zend_Db::FETCH_ASSOC);
        $out = array();
        foreach ($data as $row) {
            $out[$row['brand_id']] = $row['name'];
        }
        return $out;
    }
}