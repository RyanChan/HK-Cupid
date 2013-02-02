<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity(repositoryClass="Champs\Entity\Repository\RoleRepository")
 * @Table(name="roles")
 * @HasLifecycleCallbacks
 */
class Role{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var string $rolename
     * @Column(type="string")
     */
    private $rolename;
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
     * Initialize Method
     */
    public function __construct(){
//        $this->users = new ArrayCollection();
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