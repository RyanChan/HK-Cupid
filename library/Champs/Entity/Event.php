<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="events")
 * @HasLifecycleCallbacks
 */
class Event{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var Champs\Entity\Category $category
     * @ManyToOne(targetEntity="Category")
     */
    private $category;
    /**
     *
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User", inversedBy="events")
     */
    private $user;
    /**
     *
     * @var string $eventname
     * @Column(type="string")
     */
    private $eventname;
    /**
     *
     * @var datetime $ts_created
     * @Column(type="datetime")
     */
    private $ts_created;
    /**
     *
     * @var datetime $ts_last_updated
     * @Column(type="datetime", nullable=true)
     */
    private $ts_last_updated;
    /**
     *
     * @var ArrayCollection $profiles
     * @OneToMany(targetEntity="EventProfile", mappedBy="event")
     */
    private $profiles;
    /**
     * Initialize Method
     */
    public function __construct(){
        $this->profiles = new ArrayCollection();
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
     *
     * @param EventProfile $profile
     */
    public function setProfile(EventProfile $profile){
        foreach ($this->profiles as $p){
            if($p->profile_key == $profile->profile_key){
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
//                unset($profile);
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