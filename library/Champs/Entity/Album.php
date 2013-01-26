<?php

namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Champs\Entity\Repository\AlbumRepository")
 * @Table(name="albums")
 * @HasLifecycleCallbacks
 */
class Album {

    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;

    /**
     *
     * @var Champs\Entity\Category $category
     * @OneToOne(targetEntity="Category")
     */
    private $category;

    /**
     *
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User", inversedBy="albums")
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
     * @var ArrayCollection $photos
     * @OneToMany(targetEntity="Photo", mappedBy="album")
     */
    private $photos;

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
     * @var ArrayCollection $comments
     * @OneToMany(targetEntity="AlbumComment", mappedBy="album")
     */
    private $comments;

    /**
     *
     * @var ArrayCollection $profiles
     * @OneToMany(targetEntity="AlbumProfile", mappedBy="album", cascade={"persist", "remove"})
     */
    private $profiles;

    /**
     *
     * @var Boolean $isProfileAlbum
     * @Column(type="boolean")
     */
    private $isProfileAlbum;

    /**
     * Initialize Method
     */
    public function __construct() {
        $this->photos = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        $this->$key = $value;
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key) {
        return $this->$key;
    }

    /**
     * @PrePersist
     */
    public function doPrePersist() {
        $this->ts_created = new \DateTime();
        // default false for profile album
        $this->isProfileAlbum = false;
    }

    /**
     * @PostPersist
     */
    public function doPostPersist() {
        // create album folder
        $this->_createAlbumFolder();
    }

    /**
     * @PreUpdate
     */
    public function doPreUpdate() {
        $this->ts_last_updated = new \DateTime();
    }

    /**
     * @PostInsert
     */
    public function doPostInsert() {

    }

    /**
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    protected function setProfile(AlbumProfile $profile) {
        foreach ($this->profiles->getValues() as $p) {
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
        $profile = new \Champs\Entity\AlbumProfile();
        $profile->album = $this;
        $profile->profile_key = $key;
        $profile->profile_value = $value;

        $this->setProfile($profile);
    }

    /**
     *
     * @param string $key
     */
    public function unsetProfile($key) {
        foreach ($this->profiles->getValues() as $profile) {
            if ($profile->profile_key == $key) {
                $this->profiles->removeElement($profile);
                \Zend_Registry::get('doctrine')->getEntityManager()->remove($profile);
                return;
            }
        }
    }

    /**
     *
     * @param AlbumProfile $profile
     */
    public function getProfile($key = null) {
        if (strlen($key) > 0) {
            foreach ($this->profiles as $profile) {
                if ($profile->profile_key == $key) {
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
    public function getCreated() {
        return $this->ts_created->format('Y-m-d H:i:s');
    }

    /**
     *
     * @return \DateTime
     */
    public function getLastUpdated() {
        return ($this->ts_last_updated == null) ? null : $this->ts_last_updated->format('Y-m-d H:i:s');
    }

    /**
     * get the album folder path
     */
    public function getAlbumFolder(User $user = null) {
        $userPath = ($user == null) ? $this->user->getUserFolder() : $user->getUserFolder();

        return $userPath . DIRECTORY_SEPARATOR . 'album' . DIRECTORY_SEPARATOR . $this->id;
    }

    /**
     * create the album folder for current user
     */
    private function _createAlbumFolder() {
        $albumPath = $this->getAlbumFolder();

        if (!is_dir($albumPath))
            mkdir($albumPath, 0777);
    }

    /**
     * get the likes count
     *
     *  @return int
     */
    public function getLikeCount(){
        return $this->getProfile('likes');
    }

    /**
     *  get the dislikes count
     *
     * @return int
     */
    public function getDislikeCount(){
        return $this->getProfile('dislikes');
    }

    /**
     *  get the privacy
     *
     *  @return smallint
     */
    public function getPrivacy(){
        return $this->getProfile('privacy');
    }

    /**
     *  get the description
     *
     *  @return string
     */
    public function getDescription(){
        return $this->getProfile('description');
    }

    /**
     *  get the photo count
     *
     *  @return int
     */
    public function getPhotoCount(){
        return count($this->photos);
    }

    /**
     *  get the comments count
     *
     *  @return int
     */
    public function getCommentCount(){
        return count($this->comments);
    }

    /**
     *  set the privacy
     *
     *  @param smallint privacy
     */
    public function setPrivacy($privacy){
        $this->setProfileWithKeyAndValue('privacy', $privacy);
    }

    /**
     *  set the description
     *
     *  @param string description
     */
    public function setDesciption($description){
        $this->setProfileWithKeyAndValue('description', $description);
    }

}