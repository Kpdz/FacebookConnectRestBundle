<?php
namespace Kpdz\FacebookConnectRestBundle\DataManager;

use Facebook\GraphObject;
use FOS\UserBundle\Model\UserInterface;
use Kpdz\FacebookConnectRestBundle\Doctrine\UserManager;
use Kpdz\FacebookConnectRestBundle\Model\User;
use Kpdz\FacebookConnectRestBundle\Security\SessionManager;
use Symfony\Component\DependencyInjection\Container;
use Facebook\FacebookRequest;

/**
 * Class DataProvider
 * @package Kpdz\FacebookConnectRestBundle\DataManager
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
            $user->setBirthdayDate(new \DateTime($graphData->getProperty('birthday')));
            $user->setLocale($graphData->getProperty('locale'));
            $user->setEmail($graphData->getProperty('email'));
            $user->setPlainPassword($user->getFaceBookId());
            $user->setEnabled(true);

            // Encoding of the plain password
            $this->userManager->updatePassword($user);
            $this->userManager->updateUser($user);
        }

        return $user;
    }

}
