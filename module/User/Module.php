<?php
namespace User;

use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
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
