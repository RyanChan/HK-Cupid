<?php

/**
 * Description of Upload
 *
 * Process upload photo action
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Album_Upload extends Champs_FormProcessor {

    /**
     * Photo repository
     *
     * @var Champs\Entity\Repository\PhotoRepository $_photoRepository
     */
    private $_photoRepository = null;

    /**
     * Photo Entity
     *
     * @var Champs\Entity\Photo $photo
     */
    public $photo = null;

    public function __construct($album = null) {
        parent::__construct();

        $this->_photoRepository = $this->em->getRepository('Champs\Entity\Photo');
        $this->photo = new Champs\Entity\Photo();
        $this->photo->album = $album;
        $this->photo->user = $album->user;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // check $_FILES is empty
        if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
            $this->addError('image', $this->translator->_('Invalid upload data'));
            return false;
        }

        $file = $_FILES['image'];

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                // success
                break;

            case UPLOAD_ERR_FORM_SIZE:
            // only used if MAX_FILE_SIZE specified in form
            case UPLOAD_ERR_INI_SIZE:
                $this->addError('image', $this->translator->_('The uploaded file was too large'));
                break;

            case UPLOAD_ERR_PARTIAL:
                $this->addError('image', $this->translator->_('File was only partially uploaded'));
                break;

            case UPLOAD_ERR_NO_FILE:
                $this->addError('image', $this->translator->_('No file was uploaded'));
                break;

            case UPLOAD_ERR_NO_TMP_DIR:
                $this->addError('image', $this->translator->_('Temporary folder not found'));
                break;

            case UPLOAD_ERR_CANT_WRITE:
                $this->addError('image', $this->translator->_('Unable to write file'));
                break;

            case UPLOAD_ERR_EXTENSION:
                $this->addError('image', $this->translator->_('Invalid file extension'));
                break;

            default:
                $this->addError('image', $this->translator->_('Unknown error code'));
        }

        if ($this->hasError())
            return false;

        $info = getImageSize($file['tmp_name']);
        if (!$info) {
            $this->addError('type', $this->translator->_('Uploaded file was not an image'));
            return false;
        }

        switch ($info[2]) {
            case IMAGETYPE_PNG:
            case IMAGETYPE_GIF:
            case IMAGETYPE_JPEG:
                break;

            default:
                $this->addError('type', $this->translator->_('Invalid image type uploaded'));
                return false;
        }
        // if no errors have occurred, save the image
        if (!$this->hasError()) {
            try {
                $this->photo->uploadFile($file['tmp_name']);
                $this->photo->filepath = basename($file['name']);
                $this->photo->description = basename($file['name']);

                $this->_photoRepository->storePhotoEntity($this->photo);
            } catch (Exception $e) {
                $this->addError('error', $this->translator->_($e->getMessage()));
            }
        }

        return !$this->hasError();
    }

}
