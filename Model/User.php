<?php
namespace Kpdz\FacebookConnectRestBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Kpdz\FacebookConnectRestBundle\Model
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=false)
     */
    protected $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=10, nullable=false)
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=false)
     */
    protected $gender;

    /**
     * @var dateTime
     *
     * @ORM\Column(name="birthday_date", type="datetime", nullable=true)
     */
    protected $birthdayDate;

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return dateTime
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * @param dateTime $birthdayDate
     */
    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;
    }

}