<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Model\User as UserModel;
use User\Form\User as UserForm;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\EventManager\EventManager;

class AccountController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }
    
    public function addAction()
    {
        // The annotation builder help us create a form from the annotations in the user entity.
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
            ),
        ));

        // We bind the entity to the user. If the form tries to read/write data from/to the entity
        // it will use the hydrator specified in the entity to achieve this. In our case we use ClassMethods
        // hydrator which means that reading will happen calling the getter methods and writing will happen by
        // calling the setter methods.
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

                // We use now the Doctrine 2 entity manager to save user data to the database
                $entityManager = $this->serviceLocator->get('entity-manager');
                $entityManager->persist($entity);
                $entityManager->flush();

                $this->flashmessenger()->addSuccessMessage('User was added successfully.');

                $event = new EventManager('user');
                $event->trigger('register', $this, array(
                    'user'=> $entity,
                ));

                // redirect to view user action
                return $this->redirect()->toRoute('user/default', array(
                    'controller' => 'Account',
                    'action' => 'view',
                    'id' => $entity->getId(),
                ));
            }
        }
        
        // pass the data to the view for visualization
        return array('form1' => $form);
    }
    
    /**
     * anonymous users can use this action to register new accounts
     * 
     * @return route
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
        if(!$id) {
            // redirect to view page
            return $this->redirect()->toRoute('user/default', array(
                'controller' => 'account',
                'action' => 'view',
            ));
        }

        /*
        $userModel = new UserModel();
        $userModel->delete(array('id' => $id));
        */
        
        $entityManager = $this->serviceLocator->get('entity-manager');
        $userEntity = $this->serviceLocator->get('user-entity');
        $userEntity->setId($id);
        $entityManager->remove($userEntity);
        $entityManager->flush();
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
