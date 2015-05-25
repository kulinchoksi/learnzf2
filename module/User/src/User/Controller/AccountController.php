<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use User\Form\User as UserForm;

/**
 * Description of AccountController
 *
 * @author ASUS
 */
class AccountController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }
    
    public function addAction()
    {
        $form = new UserForm();
        
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    // merge files also with post data
                    $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                // @ToDo: save data of new user
            }
        }
        
        // pass the data to the view for visualization
        return array('form1' => $form);
    }
    
    /**
     * 
     * @return typeanonymous users can use this action to register new accounts
     */
    public function registerAction()
    {
        return array();
    }
    
    public function viewAction()
    {
        return array();
    }
    
    public function editAction()
    {
        return array();
    }
    
    public function deleteAction()
    {
        return array();
    }
}
