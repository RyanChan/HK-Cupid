<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="logging")
 * @HasLifecycleCallbacks
 */
class Logging{
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
     * @ManyToOne(targetEntity="User")
     */
    private $user;
    /**
     *
     * @var smallint $level
     * @Column(type="smallint")
     */
    private $level;
    /**
     * @var text $activity
     * @Column(type="text")
     */
    private $activity;
    /**
     *
     * @var datetime $ts_created
     * @Column(type="datetime")
     */
    private $ts_created;
    /**
     * Initialize Method
     */
    public function __construct(){

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
}