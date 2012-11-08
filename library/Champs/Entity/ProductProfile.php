<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="products_profile")
 * @HasLifecycleCallbacks
 */
class ProductProfile{
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
     * @ManyToOne(targetEntity="Product", inversedBy="products")
     */
    private $product;
    /**
     *
     * @var string $profile_key
     * @Column(type="string")
     */
    private $profile_key;
    /**
     *
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
        $this->product->doPreUpdate();
    }
}