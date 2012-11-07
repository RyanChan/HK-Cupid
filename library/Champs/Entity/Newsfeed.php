<?php
namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="newsfeeds")
 * @HasLifecycleCallbacks
 */
class Newsfeed{
    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var Champs\Entity\Category
     * @ManyToOne(targetEntity="Category")
     */
    private $category;
    /**
     *
     * @var Champs\Entity\User $user
     * @ManToOne(targetEntity="User", inversedBy="newsfeeds")
     */
    private $user;
    /**
     *
     * @var text $content
     * @Column(type="text")
     */
    private $content;
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
     * @var ArrayCollection $profiles
     * @OneToMany(targetEntity="NewsfeedProfile", mappedBy="newsfeed")
     */
    private $profiles;
    /**
     *
     * @var ArrayCollection $comments
     * @ManyToOne(targetEntity="Newsfeed")
     * @JoinColumn(name="parent_newsfeed_id", referencedColumnName="id")
     */
    private $newsfeeds;
    /**
     * Initialize Method
     */
    public function __construct(){
        $this->profiles = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
    /**
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(UserProfile $profile){
        foreach ($this->profiles as $p){
            if ($p->profile_key == $profile->profile_key){
                $p->profile_value = $profile->profile_value;
                return;
            }
        }

        $this->profiles->add($profile);
    }
    /**
     *
     * @param string $key
     */
    public function unsetProfile($key){
        foreach ($this->profiles as $profile){
            if ($profile->profile_key == $key){
                $this->profiles->removeElement($profile);
            }
        }
    }
    /**
     *
     * @param UserProfile $profile
     */
    public function getProfile($key = null){
        if (strlen($key) > 0){
            foreach ($this->profiles as $profile){
                if ($profile->profile_key == $key){
                    return $profile->profile_value;
                }
            }
            return null;
        } else {
            return $this->profiles;
        }
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