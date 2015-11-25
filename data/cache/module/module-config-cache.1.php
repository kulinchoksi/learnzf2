<?php
return array (
  'application' => 
  array (
    'name' => 'Training Center Application',
    'version' => '0.0.1',
  ),
  'router' => 
  array (
    'routes' => 
    array (
      'home' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'index',
          ),
        ),
      ),
      'application' => 
      array (
        'type' => 'Literal',
        'options' => 
        array (
          'route' => '/application',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'Application\\Controller',
            'controller' => 'Index',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'default' => 
          array (
            'type' => 'Segment',
            'options' => 
            array (
              'route' => '/[:controller[/:action]]',
              'constraints' => 
              array (
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              ),
              'defaults' => 
              array (
              ),
            ),
          ),
        ),
      ),
      'user' => 
      array (
        'type' => 'Literal',
        'options' => 
        array (
          'route' => '/user',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'User\\Controller',
            'controller' => 'Account',
            'action' => 'me',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'default' => 
          array (
            'type' => 'Segment',
            'options' => 
            array (
              'route' => '/[:controller[/:action[/:id]]]',
              'constraints' => 
              array (
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[0-9]*',
              ),
              'defaults' => 
              array (
              ),
            ),
          ),
        ),
      ),
      'exam' => 
      array (
        'type' => 'Literal',
        'options' => 
        array (
          'route' => '/exam',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'Exam\\Controller',
            'controller' => 'Test',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'default' => 
          array (
            'type' => 'Segment',
            'options' => 
            array (
              'route' => '/[:controller[/:action[/:id]]]',
              'constraints' => 
              array (
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[0-9]*',
              ),
              'defaults' => 
              array (
              ),
            ),
          ),
          'list' => 
          array (
            'type' => 'Segment',
            'options' => 
            array (
              'route' => '/test/list[/:page]',
              'constraints' => 
              array (
                'page' => '[0-9]*',
              ),
              'defaults' => 
              array (
                'controller' => 'Test',
                'action' => 'list',
                'page' => '1',
                'actioncache' => true,
                'tags' => 
                array (
                  0 => 'exam-list',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'service_manager' => 
  array (
    'factories' => 
    array (
      'translator' => 'Zend\\I18n\\Translator\\TranslatorServiceFactory',
      'cipher' => 'Application\\Service\\Factory\\SymmetricCipher',
      'navigation' => 'Zend\\Navigation\\Service\\DefaultNavigationFactory',
      'text-cache' => 'Zend\\Cache\\Service\\StorageCacheFactory',
      'var-cache' => 'Application\\Service\\Factory\\VariableCache',
      'timer' => 'Debug\\Service\\Factory\\Timer',
      'database' => 'User\\Service\\Factory\\Database',
      'entity-manager' => 'User\\Service\\Factory\\EntityManager',
      'log' => 'User\\Service\\Factory\\Log',
      'password-adapter' => 'User\\Service\\Factory\\PasswordAdapter',
      'auth' => 'User\\Service\\Factory\\Authentication',
      'acl' => 'User\\Service\\Factory\\Acl',
      'user' => 'User\\Service\\Factory\\User',
      'mail-transport' => 'Exam\\Service\\Factory\\MailTransport',
    ),
    'initializers' => 
    array (
      0 => 'Debug\\Service\\Initializer\\DbProfiler',
      1 => 'Debug\\Service\\Initializer\\CacheProfiler',
      2 => 'User\\Service\\Initializer\\Password',
    ),
    'aliases' => 
    array (
      'Application\\Timer' => 'timer',
    ),
    'invokables' => 
    array (
      'table-gateway' => 'User\\Service\\Invokable\\TableGateway',
      'user-entity' => 'User\\Model\\Entity\\User',
      'doctrine-profiler' => 'User\\Service\\Invokable\\DoctrineProfiler',
      'auth-adapter' => 'User\\Authentication\\Adapter',
      'test-manager' => 'Exam\\Model\\TestManager',
      'pdf' => 'Exam\\Service\\Invokable\\Pdf',
      'mail' => 'Exam\\Service\\Invokable\\Mail',
    ),
    'shared' => 
    array (
      'user-entity' => false,
    ),
  ),
  'translator' => 
  array (
    'locale' => 'en_US',
    'translation_file_patterns' => 
    array (
      0 => 
      array (
        'type' => 'gettext',
        'base_dir' => '/var/www/learnzf2/module/Application/config/../language',
        'pattern' => '%s.mo',
      ),
    ),
  ),
  'controllers' => 
  array (
    'invokables' => 
    array (
      'Application\\Controller\\Index' => 'Application\\Controller\\IndexController',
      'User\\Controller\\Account' => 'User\\Controller\\AccountController',
      'User\\Controller\\Log' => 'User\\Controller\\LogController',
      'Exam\\Controller\\Test' => 'Exam\\Controller\\TestController',
    ),
  ),
  'view_manager' => 
  array (
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
    'template_map' => 
    array (
      'layout/layout' => '/var/www/learnzf2/module/Application/config/../view/layout/layout.phtml',
      'application/index/index' => '/var/www/learnzf2/module/Application/config/../view/application/index/index.phtml',
      'error/404' => '/var/www/learnzf2/module/Application/config/../view/error/404.phtml',
      'error/index' => '/var/www/learnzf2/module/Application/config/../view/error/index.phtml',
      'paginator/sliding' => '/var/www/learnzf2/module/Application/config/../view/paginator/sliding.phtml',
      'user/account/add' => '/var/www/learnzf2/module/User/view/user/account/add.phtml',
      'user/account/denied' => '/var/www/learnzf2/module/User/view/user/account/denied.phtml',
      'user/account/me' => '/var/www/learnzf2/module/User/view/user/account/me.phtml',
      'user/log/in' => '/var/www/learnzf2/module/User/view/user/log/in.phtml',
    ),
    'template_path_stack' => 
    array (
      0 => '/var/www/learnzf2/module/Application/config/../view',
      'Debug' => '/var/www/learnzf2/vendor/learnzf2/debug/config/../view',
      'User' => '/var/www/learnzf2/module/User/config/../view',
      'Exam' => '/var/www/learnzf2/module/Exam/config/../view',
    ),
  ),
  'navigation' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        'label' => 'Home',
        'route' => 'home',
        'pages' => 
        array (
          0 => 
          array (
            'label' => 'About',
            'route' => 'application/default',
            'controller' => 'index',
            'action' => 'about',
          ),
          1 => 
          array (
            'label' => 'Book',
            'uri' => 'http://learnzf2.com',
          ),
        ),
      ),
      1 => 
      array (
        'label' => 'User',
        'route' => 'user/default',
        'controller' => 'account',
        'pages' => 
        array (
          0 => 
          array (
            'label' => 'Me',
            'route' => 'user/default',
            'controller' => 'account',
            'action' => 'me',
            'resource' => 'account',
            'privilege' => 'me',
          ),
          1 => 
          array (
            'label' => 'Add',
            'route' => 'user/default',
            'controller' => 'account',
            'action' => 'add',
            'resource' => 'account',
            'privilege' => 'add',
          ),
          2 => 
          array (
            'label' => 'View',
            'route' => 'user/default',
            'controller' => 'account',
            'action' => 'view',
            'resource' => 'account',
            'privilege' => 'view',
          ),
          3 => 
          array (
            'label' => 'Edit',
            'route' => 'user/default',
            'controller' => 'account',
            'action' => 'edit',
            'resource' => 'account',
            'privilege' => 'edit',
          ),
          4 => 
          array (
            'label' => 'Delete',
            'route' => 'user/default',
            'controller' => 'account',
            'action' => 'delete',
            'resource' => 'account',
            'privilege' => 'delete',
          ),
          5 => 
          array (
            'label' => 'Log in',
            'route' => 'user/default',
            'controller' => 'log',
            'action' => 'in',
            'resource' => 'log',
            'privilege' => 'in',
          ),
          6 => 
          array (
            'label' => 'Register',
            'route' => 'user/default',
            'controller' => 'account',
            'action' => 'register',
            'resource' => 'account',
            'privilege' => 'register',
          ),
          7 => 
          array (
            'label' => 'Log out',
            'route' => 'user/default',
            'controller' => 'log',
            'action' => 'out',
            'resource' => 'log',
            'privilege' => 'out',
          ),
        ),
      ),
      2 => 
      array (
        'label' => 'Exam',
        'route' => 'exam',
        'pages' => 
        array (
          0 => 
          array (
            'label' => 'List',
            'route' => 'exam/list',
            'resource' => 'test',
            'privilege' => 'list',
          ),
          1 => 
          array (
            'label' => 'Reset',
            'title' => 'Resets the test to the default set',
            'route' => 'exam/default',
            'controller' => 'test',
            'action' => 'reset',
            'resource' => 'test',
            'privilege' => 'reset',
          ),
        ),
      ),
    ),
  ),
  'timer' => 
  array (
    'times_as_float' => true,
  ),
  'table-gateway' => 
  array (
    'map' => 
    array (
      'users' => 'User\\Model\\User',
    ),
  ),
  'doctrine' => 
  array (
    'entity_path' => 
    array (
      0 => '/var/www/learnzf2/module/User/config/../src/User/Model/Entity/',
    ),
    'initializers' => 
    array (
      0 => 'User\\Service\\Initializer\\Password',
    ),
  ),
  'acl' => 
  array (
    'role' => 
    array (
      'guest' => NULL,
      'member' => 
      array (
        0 => 'guest',
      ),
      'admin' => NULL,
    ),
    'resource' => 
    array (
      'account' => NULL,
      'log' => NULL,
      'test' => NULL,
    ),
    'allow' => 
    array (
      0 => 
      array (
        0 => 'guest',
        1 => 'log',
        2 => 'in',
      ),
      1 => 
      array (
        0 => 'guest',
        1 => 'account',
        2 => 'register',
      ),
      2 => 
      array (
        0 => 'member',
        1 => 'account',
        2 => 
        array (
          0 => 'me',
        ),
      ),
      3 => 
      array (
        0 => 'member',
        1 => 'log',
        2 => 'out',
      ),
      4 => 
      array (
        0 => 'admin',
        1 => NULL,
        2 => NULL,
      ),
      5 => 
      array (
        0 => 'guest',
        1 => 'test',
        2 => 'list',
      ),
      6 => 
      array (
        0 => 'member',
        1 => 'test',
        2 => 
        array (
          0 => 'list',
          1 => 'take',
        ),
      ),
      7 => 
      array (
        0 => 'admin',
        1 => 'test',
        2 => 
        array (
          0 => 'reset',
          1 => 'certificate',
        ),
      ),
    ),
    'deny' => 
    array (
      0 => 
      array (
        0 => 'guest',
        1 => NULL,
        2 => 'delete',
      ),
    ),
    'defaults' => 
    array (
      'guest_role' => 'guest',
      'member_role' => 'member',
    ),
    'resource_aliases' => 
    array (
      'User\\Controller\\Account' => 'account',
    ),
    'modules' => 
    array (
      0 => 'User',
      1 => 'Exam',
    ),
  ),
  'view_helpers' => 
  array (
    'invokables' => 
    array (
      'formMultipleChoice' => 'Exam\\Form\\View\\Helper\\Question\\FormMultipleChoice',
      'formSingleChoice' => 'Exam\\Form\\View\\Helper\\Question\\FormSingleChoice',
      'formFreeText' => 'Exam\\Form\\View\\Helper\\Question\\FormFreeText',
      'formQuestionElement' => 'Exam\\Form\\View\\Helper\\Question\\FormQuestionElement',
    ),
  ),
  'pdf' => 
  array (
    'exam_certificate' => '/var/www/learnzf2/module/Exam/config/../samples/pdf/exam_certificate.pdf',
  ),
  'log' => 
  array (
    'priority' => 4,
  ),
  'cache' => 
  array (
    'adapter' => 
    array (
      'name' => 'filesystem',
      'options' => 
      array (
        'cache_dir' => 'data/cache/text',
      ),
    ),
    'plugins' => 
    array (
      'exception_handler' => 
      array (
        'throw_exceptions' => false,
      ),
    ),
  ),
  'var-cache' => 
  array (
    'adapter' => 
    array (
      'name' => 'filesystem',
      'options' => 
      array (
        'cache_dir' => 'data/cache/var',
      ),
    ),
    'plugins' => 
    array (
      'exception_handler' => 
      array (
        'throw_exceptions' => false,
      ),
      'serializer' => 
      array (
        'serializer' => 'Zend\\Serializer\\Adapter\\PhpSerialize',
      ),
    ),
  ),
  'cache-enabled-services' => 
  array (
    0 => 'translator',
  ),
  'cache-enabled-classes' => 
  array (
    0 => '\\Zend\\Paginator\\Paginator',
  ),
  'cipher' => 
  array (
    'adapter' => 'mcrypt',
    'options' => 
    array (
      'algo' => 'aes',
    ),
    'encryption_key' => 'QUICKBROWNFOXJUMPOVERTHELAZYDOG',
  ),
  'bcrypt' => 
  array (
    'cost' => 16,
  ),
  'db' => 
  array (
    'driver' => 'Pdo_Mysql',
    'database' => 'learnzf2',
    'username' => 'root',
    'password' => 'adminuser',
    'hostname' => 'localhost',
    'options' => 
    array (
      'buffer_results' => 1,
    ),
  ),
);