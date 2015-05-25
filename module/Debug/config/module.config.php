<?php
return array(
    
    'timers' => array( // top level config key for abstract factory
        'timer' => array( // name of service
            'timer_as_float' => true, // parameter to use for service
        ),
        'timer_non_float' => array( // name of service
            'timer_as_float' => false, // parameter to use for service
        ),
    ),
    
    'service_manager' => array(
        'abstract_factories' => array(
            'timer' => "Debug\Service\Factory\TimerAbstractFactory",
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);