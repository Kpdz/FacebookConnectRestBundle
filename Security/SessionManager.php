<?php

namespace Kpdz\FacebookConnectRestBundle\Security;

use Facebook\FacebookSession;

/**
 * Class Session
 * @package Kpdz\FacebookConnectRestBundle\Security
 */
class SessionManager
{
    /**
     * @var FacebookSession
     */
    private $session;

    /**
     * @var array
     */
    private $authorization;

    /**
     * @param array $authorization
     */
    public function __construct(array $authorization)
    {
        $this->authorization = $authorization;

    }

    /**
     * Initialize a Facebook session
     */
    protected function appSessionStart()
    {
        FacebookSession::setDefaultApplication($this->authorization['app_id'], $this->authorization['secret_id']);
    }

    /**
     * @param $userToken
     */
    public function userSessionStart($userToken)
    {
        if ($userToken) {
            $this->appSessionStart();
            $this->session = new FacebookSession($userToken);
        }
    }

    /**
     * @return FacebookSession
     */
    public function getSession()
    {
        return $this->session;
    }

}
