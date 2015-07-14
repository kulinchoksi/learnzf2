<?php

namespace UserTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AccountControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../config/application.config.php'
        );

        parent::setUp();
    }

    public function testMeAction()
    {
        $application = $this->getApplication();
        $serviceManager = $application->getServiceManager();
        $eventManager = $application->getEventManager();

        // request object can be accessed and modified
        $request = $this->getRequest();

        // dispatch returns the result
        $result = $this->dispatch('/user/account/me');
        
        $this->assertActionName('me');
        $this->assertControllerName('User\Controller\Account');

        // response object can be accessed
        $response = $this->getResponse();

        // use the response to check the status code
        $this->assertEquals(200, $response->getStatusCode());
    }
}
