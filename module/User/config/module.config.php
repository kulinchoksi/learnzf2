<?php
return array(
    'router' => array(
        'routes' => array(
            // Simply drop new controllers in, and you can access them
            // using the path /user/:controller/:action
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'me',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
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
            'database' => 'User\Service\Factory\Database'
        ),
        'invokables' => array(
            'table-gateway' => 'User\Service\Invokable\TableGateway',
            'user-entity'  => 'User\Model\Entity\User',
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
);