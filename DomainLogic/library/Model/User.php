<?php
/**
 * User Model for first iteration with MVC
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
abstract class Model_User
{
    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        $this->_table = new Zend_Db_Table('user');
    }
}