<?php 
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManager;

class LogController extends AbstractActionController
{

    public function outAction()
    {	
    	return $this->redirect()->toRoute('home');
    }
   
    public function inAction() 
    {
        if (!$this->getRequest()->isPost()) {
            // just show the login form
            return array();
        }
       
        $username = $this->params()->fromPost('username');
        $password = $this->params()->fromPost('password');

        // @todo: when authentication is implemented, the hard-coded value below has to be removed
        $isValid = 1;
        if ($isValid) {
            $this->flashMessenger()->addSuccessMessage("You are now logged in!");

            return $this->redirect()->toRoute('user/default', array(
                'controller' => 'account',
                'action' => 'me',
            ));
        } else {
            $event = new EventManager('user');
            $event->trigger('log-fail', $this, array('username'=> $username));

            // @todo: report some errors
            $this->flashMessenger()->addErrorMessage("Unauthenticated request!");
        }
    }
}
