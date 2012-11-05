<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="users_profile")
 * @HasLifecycleCallbacks
 */
class UserProfile{
    /**
     *
     * @var bigint $id
     * @Id @GeneratedValue
     * @Column(type="bigint")
     */
    private $id;
    /**
     *
     * @var \Champs\Entity\User $user
     * @ManyToOne(targetEntity="User", inversedBy="profiles")
     */
    private $user;
    /**
     *
     * @var string $profile_key
     */
    private $profile_key;
    /**
     *
     * @var text $profile_value
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
        $this->user->doPreUpdate();
    }
}