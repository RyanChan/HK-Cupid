<?php

/**
 * Create an photo
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Photo_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Photo
     *
     * @var Champs\Entity\Repository\PhotoRepository $_photoRepository
     */
    private $_photoRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Photo
     *
     * @var Champs\Entity\Photo $photo
     */
    public $photo = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_photoRepository = $this->em->getRepository('Champs\Entity\Photo');

        // initialize photo entity
        $this->photo = new Champs\Entity\Photo();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // photo description
        $this->photo_description = $this->cleanHtml($request->getPost('photo_description'));
        if(strlen($this->photo_descrippion) == 0){
            $this->addError('photo_description', $this->translator->_('Please enter the photo description'));
        }else{
            $this->photo->description = $this->photo_description;
        }
        
        // photo filepath
        $this->photo_filepath = $this->sanitize($request->getPost('photo_filepath'));
        if(strlen($this->photo_filepath) == 0){
            $this->addError('photo_filepath', $this->translator->_('Please enter the photo filepath'));
        }else{
            $this->photo->filepath = $this->photo_filepath;
        }
        
        // photo user
        $user = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->photo->user = $user;
        
        // album id
        $this->album_id = $request->getPost('album_id');
        if($this->album_id <= 0){
            $this->addError('album_id', $this->translator->_('Album id must greater than 0'));
        }else{
            $album = $this->em->find('Champs\Entity\Album', $this->album_id);
            $this->photo->album = $album;
        }
        
        //=====Profile key=====
        // privacy
        $this->photo_privacy = $this->sanitize($request->getPost('photo_privacy'));

        if ($this->photo_privacy <= 0) {
            $this->addError('photo_privacy', 'Please select the privacy of photo');
        } else {
            $this->photo->setProfileWithKeyAndValue('privacy', $this->photo_privacy);
        }
        
        // visitors
        $this->photo->setProfileWithKeyAndValue('visitors', 0);
        
        // allow_comment
        $this->photo_allow_comment = $this->sanitize($request->getPost('photo_allow_comment'));
        $this->photo->setProfileWithKeyAndValue('allow_comment', $this->photo_allow_comment);
        
        // likes
        $this->photo->setProfileWithKeyAndValue('likes', 0);
        
        // dislikes
        $this->photo->setProfileWithKeyAndValue('dislikes', 0);

        if (!$this->hasError()) {
            try {
                $this->_photoRepository->storePhotoEntity($this->photo);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}