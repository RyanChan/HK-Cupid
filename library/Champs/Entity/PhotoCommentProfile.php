<?php

/**
 * Photo comment profile
 * 
 * @Entity
 * @Table(name="photo_comments_profile")
 * @HasLifecycleCallbacks
 */
class PhotoCommentProfile {
    /**
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     * @var Champs\Entity\PhotoComment $comment
     * @ManyToOne(targetEntity="PhotoComment", inversedBy="profiles")
     */
    private $comment;
    /**
     * @var string $profile_key
     * @Column(type="string")
     */
    private $profile_key;
    /**
     * @var text $profile_value
     * @Column(type="text", nullable=true)
     */
    private $profile_value;
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
     * @PostUpdate
     */
    public function doPostUpdate(){
        $this->comment->doPreUpdate();
    }
}