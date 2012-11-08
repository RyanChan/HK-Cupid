<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="albums")
 * @HasLifecycleCallbacks
 */
class Album{
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
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User", inversedBy="albums")
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
     * @OneToMany(targetEntity="Photo", mappedBy="album")
     */
    private $photos;
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
     * @OneToMany(targetEntity="AlbumProfile", mappedBy="album")
     */
    private $profiles;
    /**
     * Initialize Method
     */
    public function __construct(){
        $this->photos = new ArrayCollection();
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