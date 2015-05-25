<?php

namespace Debug\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Debug\Service\Timer as TimerService;

/**
 * Description of Timer
 *
 * @author ASUS
 */
class Timer implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get("config");
        $timer = new TimerService($config['timer']['timer_as_float']);
        return $timer;
    }
}
