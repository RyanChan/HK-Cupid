<?php

/**
 * Create an album
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_AlbumComment_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of AlbumComment
     *
     * @var Champs\Entity\Repository\AlbumCommentRepository $_albumCommentRepository
     */
    private $_albumCommentRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of AlbumComment
     *
     * @var Champs\Entity\AlbumComment $albumComment
     */
    public $albumComment = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_albumCommentRepository = $this->em->getRepository('Champs\Entity\AlbumComment');

        // initialize album entity
        $this->albumComment = new Champs\Entity\AlbumComment();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // comment title
        $this->albumComment_title = $this->sanitize($request->getPost('albumComment_title'));

        if (strlen($this->albumComment_title) == 0){
            $this->addError('albumComment_title', $this->translator->_('Please enter the comment title'));
        } else {
            $this->albumComment->title = $this->albumComment_title;
        }
            
        // comment title
        $this->albumComment_content = $this->sanitize($request->getPost('albumComment_content'));

        if (strlen($this->albumComment_content) == 0){
            $this->addError('albumComment_content', $this->translator->_('Please enter the comment content'));
        }else{
            $this->albumComment->content = $this->albumComment_content;
        }
        
        //album id
        $this->album_id = $request->getPost('album_id');

        // comment isHidden
        $this->albumComment_isHidden = $request->getPost('albumComment_isHidden');

        if (!$this->hasError()) {
            try {
                $album = $this->em->find('Champs\Entity\Album', $this->album_id);
                $this->albumComment->album = $album;
                $this->_albumCommentRepository->storeAlbumCommentEntity($this->albumComment, $this->_user_id);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}