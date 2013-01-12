<?php

/**
 * Create an album
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Album_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Album
     *
     * @var Champs\Entity\Repository\AlbumRepository $_albumRepository
     */
    private $_albumRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Album
     *
     * @var Champs\Entity\Album $album
     */
    public $album = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_albumRepository = $this->em->getRepository('Champs\Entity\Album');

        // initialize album entity
        $this->album = new Champs\Entity\Album();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // album name
        $this->album_name = $this->sanitize($request->getPost('album_name'));

        if (strlen($this->album_name) == 0)
            $this->addError('album_name', $this->translator->_('Please enter your album name'));
        else
            $this->album->title = $this->album_name;

        // album status
        $this->album_status = $this->sanitize($request->getPost('album_status'));
        $this->album->setProfileWithKeyAndValue('privacy', $this->album_status);

        // album description
        $this->album_description = $this->cleanHtml($request->getPost('album_description'));

        if (strlen($this->album_description) > 0)
            $this->album->setProfileWithKeyAndValue ('description', $this->album_description);
            
        //Profile
            // code here

        if (!$this->hasError()) {
            try {
                $this->_albumRepository->storeAlbumEntity($this->album, $this->_user_id);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}