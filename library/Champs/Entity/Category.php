<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="categories")
 * @HasLifecycleCallbacks
 */
class Category{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var ArrayCollection $categories
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="parent_category_id", referencedColumnName="id")
     */
    private $categories;
    /**
     *
     * @var string $category_name
     * @Column(type="string")
     */
    private $category_name;
    /**
     *
     * @var boolean $enabled
     * @Column(type="boolean")
     */
    private $enabled;
    /**
     *
     * @var smallint $order
     * @Column(type="smallint")
     */
    private $ranking;
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
     * Initialize Method
     */
    public function __construct(){
        $this->categories = new ArrayCollection();
        $this->ranking = 0;
        $this->enabled = true;
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