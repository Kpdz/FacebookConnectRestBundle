<?php

namespace Kupids\Bundle\FaceBookRestServerBundle\Security;

use Facebook\FacebookSession;
use FOS\UserBundle\Model\User;
use FOS\UserBundle\Security\LoginManager;
use Symfony\Component\HttpFoundation\Response;

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
     * @var array
     */
    private $authorization;

    /**
     * @var LoginManager
     */
    private $loginManagers;

    /**
     * @var string
     */
    private $firewall;

    /**
     * @param array                $authorization
     * @param LoginManager         $loginManagers
     * @param                      $firewall
     */
    public function __construct(array $authorization, LoginManager $loginManagers, $firewall)
    {
        $this->authorization = $authorization;
        $this->loginManagers = $loginManagers;
        $this->firewall      = $firewall;
    }

    /**
     * Initialize a Facebook session
     */
    protected function appSessionStart()
    {
        FacebookSession::setDefaultApplication(
            $this->authorization['app_id'],
            $this->authorization['secret_id']);
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

    /**
     * @param User          $user
     * @param Response|null $response
     */
    public function loginUser(User $user, Response $response = null)
    {
        $this->loginManagers->loginUser($this->firewall, $user, null);
    }

}
