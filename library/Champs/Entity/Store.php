<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="stores")
 * @HasLifecycleCallbacks
 */
class Store{
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
     * @OneToOne(targetEntity="Category")
     */
    private $category;
    /**
     *
     * @var Champs\Entity\User $owner
     * @ManyToOne(targetEntity="User", inversedBy="store")
     */
    private $owner;
    /**
     *
     * @var string $storename
     * @Column(type="string")
     */
    private $storename;
    /**
     *
     * @var boolean $isOpened
     * @Column(type="boolean")
     */
    private $isOpened;
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
     * @OneToMany(targetEntity="StoreProfile", mappedBy="store")
     */
    private $profiles;
    /**
     *
     * @var ArrayCollection $comments
     * @OneToMany(targetEntity="StoreComment", mappedBy="store")
     */
    private $comments;
    /**
     *
     * @var ArrayCollection $products
     * @OneToMany(targetEntity="Product", mappedBy="store")
     */
    private $products;
    /**
     * Initialize Method
     */
    public function __construct(){
        $this->isOpened = false;
        $this->profiles = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(StoreProfile $profile){
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