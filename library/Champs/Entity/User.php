<?php

namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Champs\Entity\UserProfile;
use Champs\Entity\Album;

/**
 * @Entity(repositoryClass="Champs\Entity\Repository\UserRepository")
 * @Table(name="users")
 * @HasLifecycleCallbacks
 * @author RyanChan
 */
class User {

    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @GeneratedValue
     * @Id
     */
    private $id;

    /**
     *
     * @var string $username
     * @Column(type="string")
     */
    private $username;

    /**
     *
     * @var string $password
     * @Column(type="string", length=32)
     */
    private $password;

    /**
     *
     * @var string $password_salt
     * @Column(type="string")
     */
    private $password_salt;

    /**
     *
     * @var \Champs\Entity\Role $role
     * @ManyToOne(targetEntity="Role")
     */
    private $role;

    /**
     *
     * @var \DateTime $ts_created
     * @Column(type="datetime")
     */
    private $ts_created;

    /**
     *
     * @var \DateTime $ts_last_updated
     * @Column(type="datetime", nullable=true)
     */
    private $ts_last_updated;

    /**
     *
     * @var \DateTime $ts_last_login
     * @Column(type="datetime", nullable=true)
     */
    private $ts_last_login;

    /**
     *
     * @var \ArrayCollection $profiles
     * @OneToMany(targetEntity="UserProfile", mappedBy="user", cascade={"persist", "remove"})
     */
    private $profiles;

    /**
     *
     * @var \ArrayCollection $followers
     * @ManyToMany(targetEntity="User", inversedBy="followersWithMe")
     * @JoinTable(name="followers",
     *      joinColumns={
     *          @JoinColumn(name="user_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @JoinColumn(name="follower_user_id", referencedColumnName="id")
     *      }
     * )
     */
    private $followers;

    /**
     *
     * @var \ArrayCollection $followersWithMe
     * @ManyToMany(targetEntity="User", mappedBy="followers")
     */
    private $followersWithMe;

    /**
     *
     * @var ArrayCollection $events
     * @OneToMany(targetEntity="Event", mappedBy="user")
     */
    private $events;

    /**
     *
     * @var ArrayCollection $notifications
     * @OneToMany(targetEntity="Notification", mappedBy="receiver")
     */
    private $notifications;

    /**
     *
     * @var ArrayCollection $newsfeeds
     * @OneToMany(targetEntity="Newsfeed", mappedBy="user")
     */
    private $newsfeeds;

    /**
     *
     * @var ArrayCollection $sentMessages
     * @OneToMany(targetEntity="Message", mappedBy="sender")
     */
    private $sentMessages;

    /**
     *
     * @var ArrayCollection $receivedMessages
     * @OneToMany(targetEntity="Message", mappedBy="receiver")
     */
    private $receivedMessages;

    /**
     *
     * @var ArrayCollection $albums
     * @OneToMany(targetEntity="Album", mappedBy="user")
     */
    private $albums;

    /**
     *
     * @var ArrayCollection $payments
     * @OneToMany(targetEntity="Payment", mappedBy="user")
     */
    private $payments;

    /**
     *
     * @var ArrayCollection $products
     * @OneToMany(targetEntity="Product", mappedBy="user")
     */
    private $products;

    /**
     * Initialize method
     */
    public function __construct() {
        $this->profiles = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->followersWithMe = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->newsfeeds = new ArrayCollection();
        $this->sentMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        $this->$key = $value;
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key) {
        return $this->$key;
    }

    /**
     * @PrePersist
     */
    public function doPrePersist() {
        $this->ts_created = new \DateTime();
        $this->setProfileWithKeyAndValue('activated', 0);
        // generate activation key
        $this->generateActivationKey();
        // set role
        $this->role = \Zend_Registry::get('doctrine')->getEntityManager()->getRepository('Champs\Entity\Role')->getMemebrRole();
    }

    /**
     * @PreUpdate
     */
    public function doPreUpdate() {
        $this->ts_last_updated = new \DateTime();
    }

    /**
     * @PostPersist
     */
    public function doPostPersist() {
        // send activation email
        $this->sendComfirmEmail();
        // create media folder
        $this->_createUserFolder();
        // create album folder
        $this->_createAlbumFolder();
        // create product folder
        $this->_createProductFolder();
        // create profile album
        $this->_createProfileAlbum();
    }

    public function getUserFolder() {
        return \Zend_Registry::get('config')->image->path . DIRECTORY_SEPARATOR . $this->getProfile('email');
    }

    /**
     * Create a folder for user to store the media
     */
    private function _createUserFolder() {
        $mediaPath = $this->getUserFolder();

        if (!is_dir($mediaPath))
            mkdir($mediaPath, 0777);
    }

    private function _createAlbumFolder() {
        $albumPath = $this->getUserFolder() . DIRECTORY_SEPARATOR . 'album';

        if (!is_dir($albumPath))
            mkdir ($albumPath, 0777);
    }

    private function _createProductFolder() {
        $productPath = $this->getUserFolder() . DIRECTORY_SEPARATOR . 'product';

        if (!is_dir($productPath))
            mkdir ($productPath, 0777);
    }

    private function _createProfileAlbum() {
        $profileAlbum = new Album();
        $profileAlbum->title = 'Profile Album';
        $profileAlbum->setProfileWithKeyAndValue('privacy', 0);
        $profileAlbum->setProfileWithKeyAndValue('description', 'Profile album');
        $profileAlbum->user = $this;
        $profileAlbum->isProfileAlbum = TRUE;

        // get the entity manager
        $em = \Zend_Registry::get('doctrine')->getEntityManager();
        // persist profile album entity
        $em->persist($profileAlbum);
        $em->flush();
    }

    /**
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(UserProfile $profile) {
        foreach ($this->profiles->getValues() as $p) {
            if ($p->profile_key == $profile->profile_key) {
                $p->profile_value = $profile->profile_value;
                return;
            }
        }

        $this->profiles->add($profile);
    }

    /**
     * set up the profile object for user
     *
     * @param string $key
     * @param string $value
     */
    public function setProfileWithKeyAndValue($key, $value) {
        $profile = new \Champs\Entity\UserProfile();
        $profile->user = $this;
        $profile->profile_key = $key;
        $profile->profile_value = $value;

        $this->setProfile($profile);
    }

    /**
     *
     * @param string $key
     */
    public function unsetProfile($key) {
        foreach ($this->profiles->getValues() as $profile) {
            if ($profile->profile_key == $key) {
                $this->profiles->removeElement($profile);
                \Zend_Registry::get('doctrine')->getEntityManager()->remove($profile);
                return;
            }
        }
    }

    /**
     *
     * @param UserProfile $profile
     */
    public function getProfile($key = null) {
        if (strlen($key) > 0) {
            foreach ($this->profiles as $profile) {
                if ($profile->profile_key == $key) {
                    return $profile->profile_value;
                }
            }
            return null;
        } else {
            return $this->profiles;
        }
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->ts_created->format('Y-m-d H:i:s');
    }

    /**
     *
     * @return \DateTime
     */
    public function getLastUpdated() {
        return ($this->ts_last_updated == null) ? null : $this->ts_last_updated->format('Y-m-d H:i:s');
    }

    /**
     * Set up the password with salt and encryption
     *
     * @param type $password
     */
    public function setPassword($password) {
        $salt = sha1(md5($password . time()));
        $this->password_salt = $salt;
        $this->password = md5($password . $salt);
    }

    /**
     * Set up the username by using the email.
     *
     */
    public function setUsername($email) {
        // get the email address from the profile array
        if (empty($email))
            throw new Exception('Email address have not been set yet');

        // explode the email address by delimiter "@"
        $pattern = explode('@', $email);
        // get the first index of the array
        $username = $pattern[0];
        // set the value to username property
        $this->username = $username;
        // set as nickname by default
        $this->setProfileWithKeyAndValue('nickname', $username);
    }

    /**
     * Send confirmation email
     *
     */
    public function sendComfirmEmail() {
        $mail = new \Champs_Mail();
        $mail->setObject(array('user' => $this));
        $mail->setSubject('Email address verification');

        $name = sprintf('%s %s', $this->getProfile('first_name'), $this->getProfile('last_name'));
        $email = $this->getProfile('email');

        $mail->setTo($email, $name);

        $mail->setBodyHTML('account/email-verification.tpl');
        $mail->send();
    }

    /**
     * Generate the activation key for user
     *
     */
    public function generateActivationKey() {
        $this->setProfileWithKeyAndValue('activate_account_key', md5(uniqid() . $this->id . $this->password . $this->password_salt));
        $this->setProfileWithKeyAndValue('activate_account_ts', time());
    }

    /**
     * Update last login time
     */
    public function doUpdateLastLogin() {
        $this->ts_last_login = new \DateTime();
    }

    /**
     * Get the age of user
     *
     * @return integer|null
     */
    public function getAge() {
        // get the age
        $birthday = $this->getProfile('birthday') == null ? null : $this->getProfile('birthday');

        if ($birthday === null)
            return null;

        $date = date('Y-m-d', $birthday);

        list($year, $month, $day) = explode('-', $date);

        $year_diff = date('Y') - $year;
        $month_diff = date('m') - $month;
        $day_diff = date('d') - $day;

        if ($month_diff < 0 )
            $year_diff--;
        else if (($month_diff == 0) && ($day_diff < 0))
            $year_diff--;

        return $year_diff;
    }

    /**
     * get the gender of user
     *
     * @return string|null
     */
    public function getGender() {
        // get translator
        $translator = \Zend_Registry::get('translate');

        if ($this->getProfile('gender') == Repository\UserRepository::MALE)
            return $translator->_('Male');
        else if ($this->getProfile('gender') == Repository\UserRepository::FEMALE)
            return $translator->_('Female');
        else
            return null;
    }

    /**
     * get the first name of user
     *
     * @return string|null
     */
    public function getFirstName(){
        return $this->getProfile('first_name');
    }

    /**
     * get the last name of user
     *
     * @return string|null
     */
    public function getLastName(){
        return $this->getProfile('last_name');
    }

    /**
     * get the full name of user
     *
     * @return string|null
     */
    public function getFullName(){
        return sprintf('%s, %s', $this->getFirstName(), $this->getLastName());
    }

    /**
     * get the nick name of user
     *
     * @return string|null
     */
    public function getNickName(){
        return $this->getProfile('nickname');
    }

    /**
     * get the birthday of user
     *
     * @return int|null
     */
    public function getBirthday(){
        return $this->getProfile('birthday');
    }

    /**
     * get the intro of user
     *
     * @return text|null
     */
    public function getIntro(){
        return $this->getProfile('intro');
    }

    /**
     * get the mobile number of user
     *
     * @return string|null
     */
    public function getMobileNumer(){
        return $this->getProfile('mobile_number');
    }

    /**
     * get the email of user
     *
     * @return string|null
     */
    public function getEmail(){
        return $this->getProfile('email');
    }

    /**
     * get the friend count
     *
     * @return int|0
     */
    public function getFriendCount(){
        return $this->followers->count();
    }

    /**
     * get the friend count
     *
     * @return int|0
     */
    public function getMessageCount(){
        return $this->receivedMessages->count();
    }

    /**
     * get the product count
     *
     * @return int|0
     */
    public function getProductCount(){
        return $this->products->count();
    }

    /**
     * get the notification count
     *
     * @return int|0
     */
    public function getNotificationCount(){
        return $this->notifications->count();
    }

    /**
     * get the album count
     *
     * @return int|0
     */
    public function getAlbumCount(){
        return $this->albums->count();
    }

    /**
     * get the photo count
     *
     * @return int|0
     */
    public function getPhotoCountl(){
    }

    /**
     * @return Champs\Entity\Album|null
     */
    public function getProfileAlbum() {
        // find the profile album
        foreach ($this->albums as $album) {
            if ($album->isProfileAlbum) {
                return $album;
            }
        }

        return null;
    }

    /**
     * check the target user whether followed.
     *
     */
    public function isFollowed() {
        // get the user_id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

        foreach ($this->followers as $follower) {
            if ($follower->id == $user_id) {
                return true;
            }
        }

        return false;
    }
}