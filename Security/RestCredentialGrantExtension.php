<?php

namespace Kpdz\FacebookConnectRestBundle\Security;


use FOS\OAuthServerBundle\Storage\GrantExtensionInterface;
use Kpdz\FacebookConnectRestBundle\Doctrine\UserManager;
use OAuth2\Model\IOAuth2Client;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

/**
 * Class RestCredentialGrantExtension
 * @package Kpdz\FacebookConnectRestBundle\Security
 */
class RestCredentialGrantExtension implements GrantExtensionInterface
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * RestCredentialGrantExtension constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @see OAuth2\IOAuth2GrantExtension::checkGrantExtension
     * @param IOAuth2Client $client
     * @param array         $inputData
     * @param array         $authHeaders
     * @return array
     *
     */
    public function checkGrantExtension(IOAuth2Client $client, array $inputData, array $authHeaders)
    {
        if (!isset($inputData['facebook_id'])) {
            throw new \InvalidArgumentException("facebook_id parameter missing!");
        }

        $user = $this->userManager->findUserByFacebookId($inputData['facebook_id']);
        if ($user) {
            return ['data' => $user];
        }

        throw new AuthenticationCredentialsNotFoundException("Provided facebook ID doesn't match with any user");
    }
}