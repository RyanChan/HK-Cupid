<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="messages")
 * @HasLifecycleCallbacks
 */
class Message{
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
     * @ManyToOne(targetEntity="User", inversedBy="sentMessages")
     */
    private $sender;
    /**
     *
     * @var Champs\Entity\User $receiver
     * @ManyToOne(targetEntity="User", inversedBy="receivedMessages")
     */
    private $receiver;
    /**
     *
     * @var string $title
     * @Column(type="string")
     */
    private $title;
    /**
     *
     * @var text $content
     * @Column(type="text")
     */
    private $content;
    /**
     *
     * @var boolean $isRead
     * @Column(type="boolean")
     */
    private $isRead;
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
     *
     * @return \DateTime
     */
    public function getCreated(){
        return $this->ts_created->format('Y-m-d H:i:s');
    }
}