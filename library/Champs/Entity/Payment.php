<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="payments")
 * @HasLifecycleCallbacks
 */
class Payment{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User", inversedBy="payments")
     */
    private $user;
    /**
     *
     * @var smallint $type
     * @Column(type="smallint")
     */
    private $type;
    /**
     *
     * @var text $content
     * @Column(type="text")
     */
    private $content;
    /**
     * Progress type :
     *      1 = In Process
     *      2 = Processing
     *      3 = Ready
     *      4 = Completed
     *      5 = Ended
     *      6 = Cancel
     *      7 = On Held
     *
     * @var smallint $progress
     * @Column(type="smallint")
     */
    private $progress;
    /**
     *
     * @var datetime $ts_cretaed
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
     * Initialize method
     */
    public function __construct(){
        $this->progress = 1;
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