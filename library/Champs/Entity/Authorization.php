<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="authorizations")
 * @HasLifecycleCallbacks
 */
class Authorization{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var Champs\Entity\Resource $resource
     * @ManyToOne(targetEntity="Resource")
     */
    private $resource;
    /**
     *
     * @var Champs\Entity\Action $action
     * @ManyToOne(targetEntity="Action")
     */
    private $action;
    /**
     *
     * @var Champs\Entity\Role $role
     * @ManyToOne(targetEntity="Role")
     */
    private $role;
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
}