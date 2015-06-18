<?php

namespace Kupids\Bundle\FaceBookRestServerBundle\Security;

use Facebook\FacebookSession;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class Session
 * @package Kupids\Bundle\FacebookRestServerBundle\Security
 */
class SessionManager
{
    /**
     * @var FacebookSession
     */
    private $session;

    /**
     * @var int
     */
    private $app_id;

    /**
     * @var string
     */
    private $secret_id;

    /**
     * @param array $authorization
     */
    public function __construct(array $authorization)
    {
        $this->app_id    = $authorization['app_id'];
        $this->secret_id = $authorization['secret_id'];
    }

    protected function appSessionStart()
    {
        FacebookSession::setDefaultApplication($this->app_id, $this->secret_id);
    }

    public function userSessionStart($userToken)
    {
        if ($userToken) {
            $this->appSessionStart();
            $this->session = new FacebookSession($userToken);
        }
    }

    public function getSession()
    {
        return $this->session;
    }

}
