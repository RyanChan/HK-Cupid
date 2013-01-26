<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="products_comment")
 * @HasLifecycleCallbacks
 */
class ProductComment{
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
     * @ManyToOne(targetEntity="Product", inversedBy="comments")
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
     * @var boolean $isHidden
     */
    private $isHidden;
    /**
     *
     * @var datetime $ts_created;
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
        $this->isHidden = false;
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
    /**
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(ProductProfile $profile) {
        foreach ($this->profiles as $p) {
            if ($p->profile_key == $profile->profile_key) {
                $p->profile_value = $profile->profile_value;
                return;
            }
        }

        $this->profiles->add($profile);
    }
    /**
     * set up the profile object for user
     *
     * @param string $key
     * @param string $value
     */
    public function setProfileWithKeyAndValue($key, $value) {
        $profile = new \Champs\Entity\ProductProfile();
        $profile->product = $this;
        $profile->profile_key = $key;
        $profile->profile_value = $value;

        $this->setProfile($profile);
    }
}