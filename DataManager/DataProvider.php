<?php
namespace Kupids\Bundle\FacebookRestServerBundle\DataManager;

use Facebook\GraphObject;
use FOS\UserBundle\Model\UserInterface;
use Kupids\Bundle\FacebookRestServerBundle\Doctrine\UserManager;
use Kupids\Bundle\FacebookRestServerBundle\Model\User;
use Kupids\Bundle\FacebookRestServerBundle\Security\SessionManager;
use Symfony\Component\DependencyInjection\Container;
use Facebook\FacebookRequest;

/**
 * Class DataProvider
 * @package Kupids\Bundle\FacebookRestServerBundle\DataManager
 */
class DataProvider
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var void
     */
    private $request;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @param Container   $container
     * @param UserManager $userManager
     * @param array       $parameters
     */
    public function __construct(Container $container, UserManager $userManager, array $parameters)
    {
        $this->container   = $container;
        $this->parameters  = $parameters;
        $this->userManager = $userManager;
    }

    /**
     * @param SessionManager $session
     * @param                $accessToken
     * @param string         $method
     * @param                $action
     * @return mixed
     * @throws \Facebook\FacebookRequestException
     */
    public function setRequest(SessionManager $session, $accessToken, $method = 'GET', $action = "/me")
    {
        $this->session = $session;
        $session->userSessionStart($accessToken);
        $this->request = new FacebookRequest($session->getSession(), $method, $action, array_keys($this->parameters));
        $response      = $this->request->execute();
        $graphObject   = $response->getGraphObject();

        return $graphObject;
    }

    /**
     * @param GraphObject $graphData
     * @return UserInterface|User
     */
    public function setUserDefault(GraphObject $graphData)
    {
        $user = $this->userManager->findUserByFacebookId($graphData->getProperty('id'));

        if (null === $user) {
            $user = $this->userManager->createUser();

            $user->setFacebookId($graphData->getProperty('id'));
            $user->setUsername($graphData->getProperty('first_name'));
            $user->setGender($graphData->getProperty('gender'));
            $user->setLocale($graphData->getProperty('locale'));
            $user->setEmail($graphData->getProperty('email'));
            $user->setPassword($user->getFaceBookId());
            $user->setEnabled(true);


            $this->userManager->updateUser($user);
        }

        return $user;
    }
}
