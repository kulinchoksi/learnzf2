<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Model\User as UserModel;
use User\Form\User as UserForm;
use Zend\Form\Annotation\AnnotationBuilder;

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
        $builder = new AnnotationBuilder();
        $entity = $this->serviceLocator->get('user-entity');

        // get the values from entity and bind to form
        $form = $builder->createForm($entity);
        // $form = new UserForm();

        $form->add(
                array(
                    'name' => 'password_verify',
                    'type' => 'Zend\Form\Element\Password',
                    'attributes' => array(
                        'placeholder' => 'Verify password here...',
                        'required' => 'required',
                    ),
                    'options' => array(
                        'label' => 'Verify password',
                    )
                ), array(
                    'priority' => $form->get('password')->getOption('priority'),
                )
        );

        // to protect form submitting automated from automated script
        $form->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        // submit button
        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Submit',
                'required' => 'false',
            )
        ));

        // set the values back to entity from submitted to form
        $form->bind($entity);
        
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    // merge files also with post data
                    $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                /*
                $userModel = new UserModel();
                $id = $userModel->insert($form->getData());
                */

                $entityManager = $this->serviceLocator->get('entity-manager');
                $entityManager->persist($entity);
                $entityManager->flush();
                
                // redirect to view user action
                return $this->redirect()->toRoute('user/default', array(
                    'controller' => 'Account',
                    'action' => 'view',
                    'id' => $id,
                ));
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
        $result = $this->forward()->dispatch('User\Controller\Account', array(
            'action' => 'add',
        ));
        return $result;
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
        $id = $this->getRequest()->getQuery()->get('id');
        if ($id) {
            /*
            $userModel = new UserModel();
            $userModel->delete(array('id' => $id));
            */

            $entityManager = $this->serviceLocator->get('entity-manager');
            $userEntity = $this->serviceLocator->get('user-entity');
            $userEntity->setId($id);
            $entityManager->remove($userEntity);
            $entityManager->flush();
            
            // redirect to view page
            return $this->redirect()->toRoute('user/default', array(
                'controller' => 'account',
                'action' => 'view',
            ));
        }
        
        return array();
    }

    public function meAction()
    {
        return array();
    }

    public function deniedAction()
    {
        return array();
    }
}
