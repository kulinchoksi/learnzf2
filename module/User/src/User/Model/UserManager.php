<?php

namespace User\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserManager implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;


    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Creates and fills the user entity identified by user entity (email)
     *
     * @param string $email
     * @return Entity\User
     */
    public function create($email)
    {
        $user = $this->serviceLocator->get('user-entity');
        $entityManager = $this->serviceLocator->get('entity-manager');

        $user = $entityManager->getRepository(get_class($user))->findOneByEmail($email);

        return $user;
    }

}
