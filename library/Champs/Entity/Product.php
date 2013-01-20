<?php

namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Champs\Entity\Repository\ProductRepository")
 * @Table(name="products")
 * @HasLifecycleCallbacks
 */
class Product {

    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;

    /**
     * @var Champs\Entity\Store $store
     * @ManyToOne(targetEntity="Store", inversedBy="products")
     */
    private $store;

    /**
     *
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     *
     * @var string $title
     * @Column(type="string")
     */
    private $title;

    /**
     *
     * @var ArrayCollection $photos
     * @OneToMany(targetEntity="ProductPhoto", mappedBy="product")
     */
    private $photos;

    /**
     *
     * @var smallint $ranking
     * @Column(type="smallint")
     */
    private $ranking;

    /**
     * @var decimal $price
     * @Column(type="decimal", scale=2)
     */
    private $price;

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
     * @OneToMany(targetEntity="ProductProfile", mappedBy="product", cascade={"persist", "remove"})
     */
    private $profiles;

    /**
     *
     * @var ArrayCollection $comments
     * @OneToMany(targetEntity="ProductComment", mappedBy="product")
     */
    private $comments;

    /**
     * Initialize Method
     */
    public function __construct() {
        $this->profiles = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->ranking = 0;
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
     * @PostLoad
     */
    public function doPostLoad() {
        // increase browse counting
        $this->_increaseBrowseCounting();
    }

    /**
     * @PrePersist
     */
    public function doPrePersist() {
        $this->ts_created = new \DateTime();
    }

    /**
     * @PreUpdate
     */
    public function doPreUpdate() {
        $this->ts_last_updated = new \DateTime();
    }

    /**
     * $PostPersist
     */
    public function doPostInsert() {
        $this->_createProductFolder();
    }

    /**
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(ProductProfile $profile) {
        foreach ($this->profiles as $p) {
            if ($p->profile_key == $profile->profile_key) {
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
    public function unsetProfile($key) {
        foreach ($this->profiles as $profile) {
            if ($profile->profile_key == $key) {
                $this->profiles->removeElement($profile);
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
     * set up the profile object for user
     *
     * @param string $key
     * @param string $value
     */
    public function setProfileWithKeyAndValue($key, $value) {
        $profile = new \Champs\Entity\ProductProfile();
        $profile->product = $this;
        $profile->profile_key = $key;
        $profile->profile_value = $value;

        $this->setProfile($profile);
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
     * get product's image folder
     *
     * @param \Champs\Entity\User $user
     * @return string
     */
    public function getProductFolder(User $user = null) {
        $productPath = ($user == null) ? $this->user->getUserFolder() : $user->getUserFolder();

        return $productPath . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . $this->id;
    }

    /**
     * create a product folder
     */
    private function _createProductFolder() {
        $productPath = $this->getProductFolder();

        if (!is_dir($productPath))
            mkdir ($productPath, 0777);
    }

    /**
     * increase browse counting when the entity is loaded in everytime
     */
    private function _increaseBrowseCounting() {
        $count = $this->getProfile('browse_count');
        $count++;
        $this->setProfileWithKeyAndValue('browse_count', $count);
    }
}