<?php
/**
 * Application bootstrap
 * 
 * @author Patrick Schwisow
 * @copyright 2012
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialize autoloader
     *
     * @return void
     */
    protected function _initAutoloader()
    {
        $autoloader = $this->getApplication()->getAutoloader();
        $autoloader->setFallbackAutoloader(true);
        $autoloader->suppressNotFoundWarnings(false);
        $autoloader->registerNamespace('Zend_');
    }

    /**
     * Initialize timezone, required for Zend Framework to process date correctly
     *
     * @return void
     */
    protected function _initTimeZone()
    {
        date_default_timezone_set('America/Chicago');
    }
    
    /**
     * Initialize Database Connection
     * 
     * @return Zend_Db_Adapter_Abstract
     */
    protected function _initDb()
    {
        $options = $this->getOptions();
        
        $adapter = $options['db']['adapter'];
        $db = Zend_Db::factory($adapter, $options['db']['params']);
        Zend_Registry::set('db', $db);
        Zend_Db_Table::setDefaultAdapter($db);
        
        return $db;
    }
    
    /**
     * Inits doctrine entity manager and saves it as service
     * 
     * @return Doctrine\ORM\EntityManager
     */
    protected function _initEntityManager()
    {
        $options = $this->getOptions();
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        
//        $driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/../library/Entity');
        Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
            APPLICATION_PATH . '/../../../DoctrineORM-2.2.2/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
        );
        
        $driverImpl = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
            new \Doctrine\Common\Annotations\AnnotationReader(),
            array(realpath(APPLICATION_PATH . '/../library/Entity'))
        );
        $config->setMetadataDriverImpl($driverImpl);
        
        $config->setProxyDir(APPLICATION_PATH . '/../library/Proxy');
        $config->setProxyNamespace('Proxy');
        $config->setAutoGenerateProxyClasses(true);
        
        $connectionOptions = array(
            'driver'   => 'pdo_mysql',
            'user'     => $options['db']['params']['username'],
            'password' => $options['db']['params']['password'],
            'dbname'   => $options['db']['params']['dbname'],
            'host'     => $options['db']['params']['host']
        );
        
        return \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
    }
}
