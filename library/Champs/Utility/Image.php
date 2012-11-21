<?php

namespace Champs\Utility;

/**
 * Image function class
 *
 * Handle image upload, resize functions
 *
 * @author RyanChan
 */
class Image {

    /**
     *
     * @var string $_imagePath
     */
    private $_imagePath;

    /**
     *
     * @var string $_uploadedFile
     */
    private $_uploadedFile;

    /**
     *
     * @var string $_username
     */
    private $_username;

    /**
     *
     * @var string $_module
     */
    private $_module;

    /**
     *
     * @var string $_image_id
     */
    private $_image_id;

    /**
     * Initialize Method
     */
    public function __construct($username, $module = '', $image_id = 0) {
        // image folder location
        $this->_imagePath = \Zend_Registry::get('config')->image->path;
        // username
        $this->_username = strtolower($username);
        // module
        $this->_module = $module;
        // image id
        $this->_image_id = $image_id;
        // preInit()
        $this->_preInit();
        // createUserFolder()
        $this->_createUserFolder();
        // createModuleFolder()
        $this->_createModuleFolder();
    }

    /**
     * Check out the images folder is created
     */
    private function _preInit() {
        $path = $this->_imagePath;
        if (!is_dir($path))
            mkdir($path, 0777);
    }

    /**
     * Create exclusive folder for user
     */
    private function _createUserFolder() {
        $path = $this->getUserFolderPath();
        if (!is_dir($path))
            mkdir($path);
    }

    /**
     * Create exclusive module folder for user
     */
    private function _createModuleFolder() {
        $path = $this->getModulePath();
        if (!is_dir($path))
            mkdir($path);
    }

    /**
     * Returns true if uesr's image folder have been deleted
     *
     * @return boolean
     * @throws \Exception
     */
    public function deleteUserFolder() {
        $path = $this->getUserFolderPath();
        if (is_dir($path)) {
            $deleted = rmdir($path);
            if ($deleted) {
                return $deleted;
            } else {
                throw new \Exception("User's image folder can not be deleted!");
            }
        } else {
            throw new \Exception("User's image folder have not found!");
        }
    }

    /**
     * Returns user's folder path
     *
     * @return string
     */
    protected function getUserFolderPath() {
        return $this->_imagePath . DIRECTORY_SEPARATOR . $this->_username;
    }

    /**
     * Returns module's path
     *
     * @return string
     */
    protected function getModulePath() {
        return $this->getUserFolderPath() . DIRECTORY_SEPARATOR . $this->_module;
    }

    /**
     * Returns image's path
     *
     * @return string
     */
    public function getImagePath() {
        return $this->getModulePath() . DIRECTORY_SEPARATOR . $this->_image_id;
    }

    /**
     * Returns image thumbnail's path
     *
     * @return string
     */
    protected function getThumbnailPath() {
        return $this->getModulePath() . DIRECTORY_SEPARATOR . 'thumnails';
    }

    /**
     * Sets upload file path
     *
     * @param string $path
     * @throws \Exception
     */
    public function uploadFile($path) {
        if (!file_exists($path) || !is_file($path))
            throw new \Exception('Unable to find uploaded file');
        if (!is_readable($path))
            throw new \Exception('Unable to read uploaded file');

        $this->_uploadedFile = $path;
    }

    public function process() {
        if (strlen($this->_uploadedFile) > 0)
            return move_uploaded_file($this->_uploadedFile, $this->getImagePath());

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
        $imagePath = $this->getImagePath();
        
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
                throw new \Exception('Invalid image type');
        }

        // create a unique filename based on the specified options
        $filename = sprintf('%d.%dx%d.%d', $this->_image_id, $newW, $newH, $ts);

        // autocreate the directory for storing thumbanils
        $path = $this->getThumbnailPath();
        if (!file_exists($path))
            mkdir($path, 0777);
        if (!is_writable($path))
            throw new \Exception('Unable to write to thumbnail dir');

        // determine the full path for the new thumbnail
        $thumbPath = sprintf('%s/%s', $path, $filename);

        if (!file_exists($thumbPath)) {
            // read the image in to GD
            $im = @$infunc($imagePath);
            if (!$im)
                throw new \Exception('Unable to read image file');

            // create the output image
            $thumb = imagecreatetruecolor($newW, $newH);

            // now resample the original image to the new image
            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $newW, $newH, $w, $h);

            $outfunc($thumb, $thumbPath);
        }

        if (!file_exists($thumbPath))
            throw new \Exception('Unknown error occurred creating thumbnail');
        if (!is_readable($thumbPath))
            throw new \Exception('Unable to read thumbnail');

        return $thumbPath;
    }

    public static function GetImageHash($module, $image_id, $w, $h) {
        $module = (string) $module;
        $image_id = (int) $image_id;
        $w = (int) $w;
        $h = (int) $h;

        return md5(sprintf('%s,%s,%s,%s', $module, $image_id, $w, $h));
    }

}