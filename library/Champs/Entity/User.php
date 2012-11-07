<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Champs\Entity\UserProfile;

/**
 * @Entity
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
     * @OneToMany(targetEntity="Role", mappedBy="users")
     */
    private $role;
    /**
     *
     * @var \DateTime $ts_created
     */
    private $ts_created;
    /**
     *
     * @var \DateTime $ts_last_updated
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
    private $notifications;
    /**
     *
     * @var ArrayCollection $newsfeeds
     * @OneToMany(targetEntity="Newsfeed", mappedBy="user")
     */
    private $newsfeeds;
    private $messages;
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
        $this->messages = new ArrayCollection();
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
}