<?php
return array(
    'router' => array(
        'routes' => array(
            // Simply drop new controllers in, and you can access them
            // using the path /user/:controller/:action
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/user',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'me',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[1-9][0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Account' => 'User\Controller\AccountController',
            'User\Controller\Log'     => 'User\Controller\LogController',
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            'database' 	      => 'User\Service\Factory\Database',
            'entity-manager'  => 'User\Service\Factory\EntityManager',
            'log'             => 'User\Service\Factory\Log',
        ),
        'invokables' => array(
            'table-gateway'     => 'User\Service\Invokable\TableGateway',
            'user-entity'       => 'User\Model\Entity\User',
            'doctrine-profiler' => 'User\Service\Invokable\DoctrineProfiler',
        ),
        'shared' => array(
            'user-entity' => false,
        )
    ),

    'table-gateway' => array(
        'map' => array(
            'users' => 'User\Model\User',
        )
    ),

    'doctrine' => array(
        'entity_path' => array(
            __DIR__ . '/../src/User/Model/Entity/',
        ),
        'initializers' => array(
            // list of initializers for Doctrine 2 entities
            
        ),
    ),
);
