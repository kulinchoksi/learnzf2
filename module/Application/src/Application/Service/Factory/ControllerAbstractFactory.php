<?php

namespace Application\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ControllerAbstractFactory
 *
 * @author ASUS
 */
class ControllerAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        return class_exists($requestedName . "Controller");
    }

    /**
     * (non-PHPdoc) @see Zend\ServiceManager\AbstractFactoryInterface::createServiceWithName()
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return object controller instance
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        $className = $requestedName . "Controller";
        $instance = new $className();
        return $instance;
    }

}
