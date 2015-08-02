<?php
namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $event)
    {
        $services = $event->getApplication()->getServiceManager();
        $dbAdapter = $services->get('database');
        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($dbAdapter);
        
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'protectPage'), -100);

        $sharedEventManager = $event->getApplication()->getEventManager()->getSharedManager();
        $sharedEventManager->attach('user','log-fail', function($event) use ($services) {
            $username = $event->getParam('username');

            $log = $services->get('log');
            $log->warn('Error logging user ['.$username.']');
        });

        $sharedEventManager->attach('user','register', function($event) use ($services) {
            $user= $event->getParam('user');

            $log = $services->get('log');
            $log->warn('Registered user ['.$user->getName().'/'.$user->getId().']');
        });
    }
    
    public function protectPage(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        // var_dump($match); exit;
        if (!$match) {
            // we cannot do anything without a resolved route
            return;
        }
        
        $controller = $match->getParam('controller');
        $action = $match->getParam('action');
        $namespace = $match->getParam('__NAMESPACE__');
    }
}
