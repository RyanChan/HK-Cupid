<?php

/**
 * Create an eventComment
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_EventComment_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of EventComment
     *
     * @var Champs\Entity\Repository\EventCommentRepository $_eventCommentRepository
     */
    private $_eventCommentRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of EventComment
     *
     * @var Champs\Entity\EventComment $eventComment
     */
    public $eventComment = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_eventCommentRepository = $this->em->getRepository('Champs\Entity\EventComment');

        // initialize event entity
        $this->eventComment = new Champs\Entity\EventComment();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // comment title
        $this->eventComment_title = $this->sanitize($request->getPost('eventComment_title'));

        if (strlen($this->eventComment_title) == 0){
            $this->addError('eventComment_title', $this->translator->_('Please enter the comment title'));
        } else {
            $this->eventComment->title = $this->eventComment_title;
        }
            
        // comment content
        $this->eventComment_content = $this->sanitize($request->getPost('eventComment_content'));

        if (strlen($this->eventComment_content) == 0){
            $this->addError('eventComment_content', $this->translator->_('Please enter the comment content'));
        }else{
            $this->eventComment->content = $this->eventComment_content;
        }
        
        // event id
        $this->event_id = $request->getPost('event_id');

        // comment isHidden
        $this->eventComment_isHidden = $request->getPost('eventComment_isHidden');
        $this->eventComment->isHidden = $this->eventComment_isHidden;
        
        //Profile
            // code here

        if (!$this->hasError()) {
            try {
                // get event entity
                $event = $this->em->find('Champs\Entity\Event', $this->event_id);
                $this->eventComment->event = $event;
                
                $this->_eventCommentRepository->storeEventCommentEntity($this->eventComment, $this->_user_id);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}