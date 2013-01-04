<?php

namespace Champs\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Champs\Entity\Repository\PhotoRepository")
 * @Table(name="photos")
 * @HasLifecycleCallbacks
 */
class Photo {

    /**
     *
     * @var bigint $id
     * @Column(type="bigint")
     * @Id @GeneratedValue
     */
    private $id;

    /**
     *
     * @var Champs\Entity\Album $album
     * @ManyToOne(targetEntity="Album", inversedBy="photos")
     */
    private $album;

    /**
     *
     * @var Champs\Entity\User $user
     * @ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     *
     * @var text $description
     * @Column(type="text")
     */
    private $description;

    /**
     *
     * @var string $filepath
     * @Column(type="string")
     */
    private $filepath;

    /**
     *
     * @var ArrayCollection $profiles
     * @OneToMany(targetEntity="PhotoProfile", mappedBy="photo")
     */
    private $profiles;

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
     * @OneToMany(targetEntity="PhotoComment", mappedBy="photo")
     */
    private $comments;

    /**
     * Album folder path
     *
     * @var string $_imagePath
     */
    private $_albumPath;

    /**
     * Uploaded file
     *
     * @var string $_uploadedFile
     */
    private $_uploadedFile;

    /**
     * Initialize Method
     */
    public function __construct() {
        $this->profiles = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        switch ($key) {
            case 'album':
                $this->_albumPath = $value->getAlbumFolder();
                $this->$key = $value;
                break;
            default:
                $this->$key = $value;
                break;
        }
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
     *
     * @param string $profile_key
     * @param string $profile_value
     */
    public function setProfile(UserProfile $profile) {
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
        $profile = new \Champs\Entity\UserProfile();
        $profile->user = $this;
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
     * @param PhotoProfile $profile
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
     * @PrePersist
     */
    public function doPrePersist() {
        $this->ts_created = new \DateTime();
    }

    /**
     * @PreUpdate
     */
    public function doPreUpdate() {
        $this->ts_last_updated = new \DateTime();
    }

    /**
     * @PostLoad
     */
    public function doPostLoad() {
        // get the album path when load
        $this->_albumPath = $this->album->getAlbumFolder();
    }

    /**
     * @PostPersist
     */
    public function doPostPersist() {
        $this->uploadProcess();
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

    public function getThumbnailPath() {
        return $this->_albumPath . DIRECTORY_SEPARATOR . 'thumbnail';
    }

    public function uploadFile($path) {
        if (!file_exists($path) || !is_file($path))
            throw new \Exception('Unable to find uploaded file');
        if (!is_readable($path))
            throw new \Exception('Unable to read uploaded file');

        $this->_uploadedFile = $path;
    }

    public function getFullPath() {
        return sprintf('%s/%d', $this->_albumPath, $this->id);
    }

    public function uploadProcess() {
        if (strlen($this->_uploadedFile) > 0)
            return move_uploaded_file($this->_uploadedFile, $this->getFullPath());

        return false;
    }

    /**
     * Create thumbnail image
     *
     * @param integer $maxW
     * @param integer $maxH
     * @return string
     * @throws \Exception
     */
    public function createThumbnail($maxW, $maxH) {
        $imagePath = $this->getFullPath();

        $ts = (int) filemtime($imagePath);
        $info = getimagesize($imagePath);

        // original width
        $w = $info[0];
        // original height
        $h = $info[1];

        // width/height ratio
        $ratio = $w / $h;

        // new width can't be more than $maxW
        $maxW = min($w, $maxW);
        // check if only max height has been specified
        if ($maxW == 0)
            $maxW = $w;

        // new height can't be more than $maxH
        $maxH = min($h, $maxH);
        // check if only max width has been specified
        if ($maxH == 0)
            $maxH = $h;

        // first use the max width to determine new
        // height by using original image w:h ratio
        $newW = $maxW;
        $newH = $newW / $ratio;

        // check if new height is too big, and if
        // so determine the new width based on the
        // max height
        if ($newH > $maxH) {
            $newH = $maxH;
            $newW = $newH * $ratio;
        }

        if ($w == $newW && $h == $newH) {
            // no thumbnail required, just return the original path
            return $imagePath;
        }

        switch ($info[2]) {
            case IMAGETYPE_GIF:
                $infunc = 'ImageCreateFromGif';
                $outfunc = 'ImageGif';
                break;

            case IMAGETYPE_JPEG:
                $infunc = 'ImageCreateFromJpeg';
                $outfunc = 'ImageJpeg';
                break;

            case IMAGETYPE_PNG:
                $infunc = 'ImageCreateFromPng';
                $outfunc = 'ImagePng';
                break;

            default:
                throw new Exception('Invalid image type');
        }

        // create a unique filename based on the specified options
        $filename = sprintf('%d.%dx%d.%d', $this->id, $newW, $newH, $ts);

        // autocreate the directory for storing thumbanils
        $path = $this->getThumbnailPath();
        if (!file_exists($path))
            mkdir($path, 0777);
        if (!is_writable($path))
            throw new Exception('Unable to write to thumbnail dir');

        // determine the full path for the new thumbnail
        $thumbPath = sprintf('%s/%s', $path, $filename);

        if (!file_exists($thumbPath)) {
            // read the image in to GD
            $im = @$infunc($imagePath);
            if (!$im)
                throw new Exception('Unable to read image file');

            // create the output image
            $thumb = imagecreatetruecolor($newW, $newH);

            // now resample the original image to the new image
            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $newW, $newH, $w, $h);

            $outfunc($thumb, $thumbPath);
        }

        if (!file_exists($thumbPath))
            throw new Exception('Unknown error occurred creating thumbnail');
        if (!is_readable($thumbPath))
            throw new Exception('Unable to read thumbnail');

        return $thumbPath;
    }

    public static function GetImageHash($image_id, $w, $h) {
        $image_id = (int) $image_id;
        $w = (int) $w;
        $h = (int) $h;

        return md5(sprintf('%s,%s,%s', $image_id, $w, $h));
    }

}