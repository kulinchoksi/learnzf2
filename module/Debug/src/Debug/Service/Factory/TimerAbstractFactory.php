<?php

namespace Debug\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Debug\Service\Timer as TimerService;

/**
 * Description of TimerAbstractFactory
 *
 * @author ASUS
 */
class TimerAbstractFactory implements AbstractFactoryInterface
{
    
    /**
     *
     * @var type Configuration key holding timer configuration
     * 
     * @var string
     */
    protected $configKey = 'timers';
    
    /**
     * Check if we can create service for requested name
     * 
     * @param ServiceLocatorInterface $services
     * @param string $name
     * @param string $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        $config = $services->get("config");
        if (empty($config)) {
            return false;
        }
        
        return isset($config[$this->configKey][$requestedName]);
    }

    public function createServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        $config = $services->get("config");
        
        $timer = new TimerService($config[$this->configKey][$requestedName]['timer_as_float']);
        
        return $timer;
    }

}
