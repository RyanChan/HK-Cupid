<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="countries")
 * @HasLifecycleCallbacks
 */
class Country{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @generatedValue
     */
    private $id;
    /**
     *
     * @var string $country_name
     * @Column(type="string")
     */
    private $country_name;
    /**
     *
     * @var ArrayCollection $cities
     * @OneToMany(targetEntity="City", mappedBy="country")
     */
    private $cities;
    /**
     *
     * @var datetime $ts_created
     * @Column(type="datetime")
     */
    private $ts_creatd;
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
        $this->cities = new ArrayCollection();
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
     */
    public function __get($key){
        return $this->$key;
    }
    /**
     * @PrePersist
     */
    public function doPrePersist(){
        $this->ts_creatd = new \DateTime();
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