<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Champs\Entity\UserProfile;

/**
 * @Entity(repositoryClass="Champs\Entity\Repository\UserRepository")
 * @Table(name="users")
 * @HasLifecycleCallbacks
 * @author RyanChan
 */
class User{
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
     * @var \ArrayCollection $profiles
     * @OneToMany(targetEntity="UserProfile", mappedBy="user")
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
     * Initialize method
     */
    public function __construct(){
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
    }
    /**
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value){
        $this->$key = $value;
    }
    /**
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key){
        return $this->$key;
    }
    /**
     * @PrePersist
     */
    public function doPrePersist(){
        $this->ts_created = new \DateTime();
    }
    /**
     * @PreUpdate
     */
    public function doPreUpdate(){
        $this->ts_last_updated = new \DateTime();
    }
    /**
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(UserProfile $profile){
        foreach ($this->profiles as $p){
            if ($p->profile_key == $profile->profile_key){
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
    public function setProfileWithKeyAndValue($key, $value){
        $profile = new \Champs\Entity\UserProfile();
        $profile->user = $this;
        $profile->profile_key = $key;
        $profile->profile_value = $value;

        \Zend_Registry::get('doctrine')->getEntityManager()->persist($profile);

        $this->setProfile($profile);
    }
    /**
     *
     * @param string $key
     */
    public function unsetProfile($key){
        foreach ($this->profiles as $profile){
            if ($profile->profile_key == $key){
                $this->profiles->removeElement($profile);
            }
        }
    }
    /**
     *
     * @param UserProfile $profile
     */
    public function getProfile($key = null){
        if (strlen($key) > 0){
            foreach ($this->profiles as $profile){
                if ($profile->profile_key == $key){
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
    public function getCreated(){
        return $this->ts_created->format('Y-m-d H:i:s');
    }
    /**
     *
     * @return \DateTime
     */
    public function getLastUpdated(){
        return ($this->ts_last_updated == null) ? null : $this->ts_last_updated->format('Y-m-d H:i:s');
    }

    /**
     * Set up the password with salt and encryption
     *
     * @param type $password
     */
    public function setPassword($password){
        $salt = sha1(md5($password.time()));
        $this->password_salt = $salt;
        $this->password = md5($password.$salt);
    }

    /**
     * Set up the username by using the email.
     *
     */
    public function setUsername($email){
        // get the email address from the profile array
        if (empty($email))
            throw new Exception ('Email address have not been set yet');

        // explode the email address by delimiter "@"
        $pattern = explode('@', $email);
        // get the first index of the array
        $username = $pattern[0];
        // set the value to username property
        $this->username = $username;
    }

    /**
     * Send confirmation email
     *
     */
    public function sendComfirmEmail(){
        $mail = new \Champs_Mail();
        $mail->setObject(array('user' => $this));
        $mail->setSubject('Email address verification');

        $name = sprintf('%s %s', $this->getProfile('first_name'), $this->getProfile('last_name'));
        $email = $this->getProfile('email');

        $mail->setTo($email, $name);

        $mail->setBodyHTML('account/email-verification.tpl');
        $mail->send();
    }
}