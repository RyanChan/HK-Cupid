<?php

/**
 * Description of Edit
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Album_Edit extends Champs_FormProcessor {

    /**
     *
     * @var Champs\Entity\Repository\AlbumRepository $_albumRepository
     */
    private $_albumRepository = null;

    /**
     *
     * @var Champs\Entity\Album $album
     */
    public $album = null;

    /**
     *
     * @param integer $album_id
     */
    public function __construct($album) {
        parent::__construct();

        $this->_albumRepository = $this->em->getRepository('Champs\Entity\Album');
        $this->album = $album;
        if ($this->album) {
            $this->album_name = $this->album->title;
            $this->album_status = $this->album->getProfile('privacy');
            $this->album_description = $this->album->getProfile('description');
        }
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
            $this->album->setProfileWithKeyAndValue('description', $this->album_description);

        if (!$this->hasError()) {
            try {
                // update entity
                $this->em->flush();
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}