<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="notifications")
 * @HasLifecycleCallbacks
 */
class Notification{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var Champs\Entity\User $sender
     * @OneToOne(targetEntity="User")
     */
    private $sender;
    /**
     *
     * @var ArrayCollection $receivers
     * @ManyToOne(targetEntity="User")
     */
    private $receiver;
    /**
     *
     * @var text $message
     * @Column(type="text")
     */
    private $message;
    /**
     *
     * @var boolean $isRead
     * @Column(type="boolean")
     */
    private $isRead;
    /**
     *
     * @var string $targetType
     * @Column(type="string")
     */
    private $targetType;
    /**
     *
     * @var bigint $targetEntity
     * @Column(type="bigint")
     */
    private $targetEntity;
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
        $this->sender = new ArrayCollection();
        $this->isRead = false;
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
        $this->ts_created = new \DateTime();
    }
    /**
     *
     * @return \DateTime
     */
    public function getCreated(){
        return $this->ts_created->format('Y-m-d H:i:s');
    }
}