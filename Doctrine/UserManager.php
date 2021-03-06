<?php

namespace Kpdz\FacebookConnectRestBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Kpdz\FacebookConnectRestBundle\Model\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class UserManager
 * @package Kpdz\FacebookConnectRestBundle\Doctrine
 */
class UserManager extends BaseUserManager
{
    /**
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface  $usernameCanonicalizer
     * @param CanonicalizerInterface  $emailCanonicalizer
     * @param ObjectManager           $om
     * @param string                  $class
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, ObjectManager $om, $class)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);
    }

    /**
     * @param $facebookId
     * @return User
     */
    public function findUserByFacebookId($facebookId)
    {
        return $this->repository->findOneBy(array('facebookId' => $facebookId));
    }
}