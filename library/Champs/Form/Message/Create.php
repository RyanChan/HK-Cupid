<?php

/**
 * Create an message
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Message_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Message
     *
     * @var Champs\Entity\Repository\MessageRepository $_messageRepository
     */
    private $_messageRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Message
     *
     * @var Champs\Entity\Message $message
     */
    public $message = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_messageRepository = $this->em->getRepository('Champs\Entity\Message');

        // initialize message entity
        $this->message = new Champs\Entity\Message();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // message receiver
        $this->message_receiver = $request->getPost('message_receiver');

        if ($this->message_receiver <= 0){
            $this->addError('message_receiver', $this->translator->_('Message receiver must greater than 0'));
        } else {
            $receiver = $this->em->find('Champs\Entity\User', $this->message_receiver);
            $this->message->receiver = $receiver;
        }
        
        // message sender
        $sender = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->message->sender= $sender;
        
        // message title
        $this->message_title = $this->sanitize($request->getPost('message_title'));
        if(strlen($this->message_title) == 0){
            $this->addError('message_title', $this->translator->_('Please enter message title'));
        } else {
            $this->message->title = $this->message_title;
        }
        
        // message content
        $this->message_content = $this->cleanHtml($request->getPost('message_content'));
        if(strlen($this->message_content) == 0){
            $this->addError('message_content', $this->translator->_('Please enter message content'));
        } else {
            $this->message->content = $this->message_content;
        }
        

        if (!$this->hasError()) {
            try {
                $this->_messageRepository->storeMessageEntity($this->message);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}