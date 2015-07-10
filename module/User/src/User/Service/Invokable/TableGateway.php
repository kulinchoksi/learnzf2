<?php

namespace User\Service\Invokable;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway as DbTableGateway;

/**
 * Description of TableGateway
 *
 * @author ckulin
 */
class TableGateway implements ServiceLocatorAwareInterface
{

    protected $serviceLocator;

    protected $cache;

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function get($tableName, $features=null, $resultSetPrototype=null)
    {
        $cacheKey = $tableName;
        // $cacheKey = md5(serialize($tableName . $features . $resultSetPrototype));

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $config = $this->serviceLocator->get('config');

        // define which class should be used for which table
        $tableGatewayMap = $config['table-gateway']['map'];
        if (isset($tableGatewayMap[$tableName])) {
            $tableClassName = $tableGatewayMap[$tableName];
            $this->cache[$cacheKey] = new $tableClassName();
        }

        $db = $this->serviceLocator->get('database');
        $this->cache[$cacheKey] = new DbTableGateway($tableName, $db, $features, $resultSetPrototype);

        return $this->cache[$cacheKey];
    }

}
