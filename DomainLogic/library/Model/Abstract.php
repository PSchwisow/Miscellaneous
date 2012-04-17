<?php
/**
 * Abstract Model for first iteration with MVC
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
abstract class Model_Abstract
{
    /**
     * Table to use
     * 
     * @var Zend_Db_Table
     */
    protected $_table;
    
    /**
     * Insert new record
     * 
     * @param array $data
     * @return integer
     */
    public function insert($data)
    {
        return $this->_table->insert($data);
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
        return $this->_table->update($data, $where);
    }
    
    /**
     * Fetch data based on where clause
     * 
     * @param  string|array $where   SQL WHERE clause.
     * @return array|null The row results, in FETCH_ASSOC mode.
     */
    public function fetchAll($where = null)
    {
        $select = $this->_table->getAdapter()->select();
        $select->from($this->_table->info(Zend_Db_Table::NAME));
        // the WHERE clause
        $where = (array) $where;
        foreach ($where as $key => $val) {
            // is $key an int?
            if (is_int($key)) {
                // $val is the full condition
                $select->where($val);
            } else {
                // $key is the condition with placeholder,
                // and $val is quoted into the condition
                $select->where($key, $val);
            }
        }
        $stmt = $this->_table->getAdapter()->query($select);
        $data = $stmt->fetchAll(Zend_Db::FETCH_ASSOC);
        if (0 == count($data)) {
            return null;
        }
        return $data;
    }
}