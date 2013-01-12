<?php

/**
 * Create an photoComment
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Photo_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of PhotoComment
     *
     * @var Champs\Entity\Repository\PhotoCommentRepository $_photoCommentRepository
     */
    private $_photoCommentRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of PhotoComment
     *
     * @var Champs\Entity\PhotoComment $photoComment
     */
    public $photoComment = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_photoCommentRepository = $this->em->getRepository('Champs\Entity\PhotoComment');

        // initialize photoComment entity
        $this->photoComment = new Champs\Entity\PhotoComment();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // photoComment title
        $this->photoComment_title = $this->sanitize($request->getPost('photoComment_title'));
        if(strlen($this->photoComment_title) == 0){
            $this->addError('photoComment_title', $this->translator->_('Please enter the photoComment title'));
        }else{
            $this->photoComment->title = $this->photoComment_title;
        }
        
        // photoComment content
        $this->photoComment_content = $this->cleanHtml($request->getPost('photoComment_content'));
        if(strlen($this->photoComment_content) == 0){
            $this->addError('photoComment_content', $this->translator->_('Please enter the photoComment content'));
        }else{
            $this->photoComment->content = $this->photoComment_content;
        }
        
        // photoComment user
        $user = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->photoComment->user = $user;
        
        // photo id
        $this->photo_id = $request->getPost('photo_id');
        if($this->photo_id <= 0){
            $this->addError('photo_id', $this->translator->_('Photo id must greater than 0'));
        }else{
            $photo = $this->em->find('Champs\Entity\Photo', $this->photo_id);
            $this->photoComment->photo = $photo;
        }
        
        //Profile
            //code here

        if (!$this->hasError()) {
            try {
                $this->_photoCommentRepository->storePhotoCommentEntity($this->photoComment);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}