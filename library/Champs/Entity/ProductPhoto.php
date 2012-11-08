<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="products_photo")
 * @HasLifecycleCallbacks
 */
class ProductPhoto{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var Champs\Entity\Product $product
     * @ManyToOne(targetEntity="Product", inversedBy="photos")
     */
    private $product;
    /**
     *
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User")
     */
    private $user;
    /**
     *
     * @var text $description
     * @Column(type="text")
     */
    private $description;
    /**
     *
     * @var string $filepath
     * @Column(type="string")
     */
    private $filepath;
    /**
     *
     * @var ArrayCollection $profiles
     * @OneToMany(targetEntity="ProductPhotoProfile", mappedBy="productphoto")
     */
    private $profiles;
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
     * @var ArrayCollection $comments
     * @OneToMany(targetEntity="ProductPhotoComment", mappedBy="photo")
     */
    private $comments;
    /**
     * Initialize Method
     */
    public function __construct(){
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