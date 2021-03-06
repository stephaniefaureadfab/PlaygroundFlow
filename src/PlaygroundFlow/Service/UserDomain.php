<?php

namespace PlaygroundFlow\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use PlaygroundFlow\Entity\OpenGraphUserDomain as UserDomainEntity;


class UserDomain implements ServiceManagerAwareInterface
{
    /**
    * @var Mapper\UserDomain $userDomainMapper
    */
    protected $userDomainMapper = null;
    

    /**
    * findUserDomainOrCreateByUserAndDomain : retrieve userDomain with user and domain of create if not exits
    * @param User $user
    * @param Domain $domain
    *
    * @return UserDomain $userDomain
    */
    public function findUserDomainOrCreateByUserAndDomain($user, $domain)
    {
        $userDomain = $this->getUserDomainMapper()->findBy(array('user' => $user, 'domain' => $domain));
        if (empty($userDomain)) {
            $userDomain = new UserDomainEntity();
            $userDomain->setDomain($domain)
                ->setUser($user);
            $userDomain = $this->getUserDomainMapper()->insert($userDomain);
        }

        return $userDomain;
    }
  
  
    public function getUserDomainMapper()
    {
        if($this->userDomainMapper == null) {
            $this->userDomainMapper = $this->getServiceManager()->get('playgroundflow_user_domain_mapper');
        }

        return $this->userDomainMapper;
    }

     /**
     * set prospect mapper instance
     *
     * @return ServiceManager
     */
    public function setUserDomainMapper($mapper)
    {
        $this->userDomainMapper = $mapper;

        return $this;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param  ServiceManager $locator
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }
}