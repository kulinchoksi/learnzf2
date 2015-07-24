<?php
namespace Debug\Service\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\Db\Adapter\Profiler\Profiler;
use Zend\Db\Adapter\Profiler\ProfilerAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbProfiler implements InitializerInterface
{
    /**
     *
     * @var Zend\Db\Adapter\Profiler\Profiler
     */
    protected $profiler;

    /**
     * Initialize
     *
     * @param ProfilerAwareInterface $instance
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof ProfilerAwareInterface) {
            $instance->setProfiler($this->getProfiler($serviceLocator));
        }
    }

    public function getProfiler(ServiceLocatorInterface $serviceLocator)
    {
        if (!$this->profiler) {
            if ($serviceLocator->has('database-profiler')) {
                $this->profiler = $serviceLocator->get('database-profiler');
            } else {
                $this->profiler = new Profiler();
                $serviceLocator->setService('database-profiler', $this->profiler);
            }
        }
        return $this->profiler;
    }
}
