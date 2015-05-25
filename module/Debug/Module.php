<?php
namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
// use Zend\Mvc\Module\RouteListner;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\EventManager\Event;
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
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    // called during the initialization of Module (loadModule event)
    public function init(ModuleManager $moduleManager)
    {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST,
                array($this, 'loadedModulesInfo'));
    }
    
    public function loadedModulesInfo(Event $event)
    {
        $moduleManager = $event->getTarget();
        $loadedModules = $moduleManager->getLoadedModules();
        error_log(var_export($loadedModules, true));
    }
    
    // this method is called when bootstrap event fired,
    // which is end of preparation phase of zf2 framework execution flow
    // set prority of listner 'handleError' as higher (100)
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'), 100);
        
        // get access to service manager
        $serviceManager = $e->getApplication()->getServiceManager();
        $timer = $serviceManager->get("timer");
        $timer->start("MVC-execution");
        
        // attach a listner to finish event with priority 2
        // priority 2 because the listner with that priority will just execute before actual finish event is triggered
        $eventManager->attach(MvcEvent::EVENT_FINISH, array($this, "getMvcDuration"), 2);
        
        // attach a listner to add view layout as debug overlay while view rendering
        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, "addDebugOverlay"), 100);
        
        // attach own event listener with shared event manager
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach("channel-25", "new song", function (Event $event) {
            $artist = $event->getParam("artist");
            error_log("Got new song from artist: " . $artist);
        });
    }
    
    // dispatch error handler/callback
    public function handleError(MvcEvent $event)
    {
        $controller = $event->getController();
        $error = $event->getParam('error');
        $exception = $event->getParam('exception');
        $message = 'Controller:' . $controller . ', Error:' . $error;
        
        if ($exception instanceof \Exception) {
            $message .= ', Exception(' . $exception->getMessage() . '):' . $exception->getTraceAsString();
        }
        
        error_log($message);
        
        // stop propogation will stop execution here and stops execution of other event listners further
        // $event->stopPropagation(true);
    }
    
    public function getMvcDuration(MvcEvent $event)
    {
        // get service manager
        $serviceManager = $event->getApplication()->getServiceManager();
        
        // get already created instance of timer service
        $timer = $serviceManager->get("timer");
        
        $duration = $timer->stop("MVC-execution");
        
        // print the duration in error log
        error_log("MVC duration:" . $duration . " seconds");
    }
    
    public function addDebugOverlay(MvcEvent $event)
    {
        $viewModel = $event->getViewModel();
        
        $sidebarView = new \Zend\View\Model\ViewModel();
        $sidebarView->setTemplate('debug/layout/sidebar');
        $sidebarView->addChild($viewModel, 'content');
        
        $event->setViewModel($sidebarView);
    }
}
