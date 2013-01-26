<?php

/**
 * Create an event
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Event_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Event
     *
     * @var Champs\Entity\Repository\EventRepository $_eventRepository
     */
    private $_eventRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Event
     *
     * @var Champs\Entity\Event $event
     */
    public $event = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_eventRepository = $this->em->getRepository('Champs\Entity\Event');

        // initialize event entity
        $this->eventComment = new Champs\Entity\Event();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // event name
        $this->event_name = $this->sanitize($request->getPost('event_name'));

        if (strlen($this->event_name) == 0){
            $this->addError('event_name', $this->translator->_('Please enter the event name'));
        } else {
            $this->event->eventname = $this->event_name;
        }
        
        //category id
        $this->category_id = $request->getPost('category_id');
        
        if($this->category_id <= 0){
            $this->addError('category_id', $this->translator->_('Category id must greater than 0'));
        }
        
        // description
        $this->event_description = $request->getPost('event_description');
        
        if(strlen($this->event_description) == 0){
            $this->addError('event_description', $this->translator->_('Please enter the description of the event'));
        }else{
            $this->event->setProfileWithKeyAndValue('description', $this->event_description);
        }
        
        //privacy
        $this->event_privacy = $request->getPost('event_privacy');
        
        if($this->event_privacy <= 0){
            $this->addError('event_privacy', $this->translator->_('Please select the privacy of the event'));
        }else{
            $this->event->setProfileWithKeyAndValue('privacy', $this->event_privacy);
        }
        
        //status
        $this->event_status = $request->getPost('event_status');
        
        if($this->event_status <= 0){
            $this->addError('event_status', $this->translator->_('Please select the status of the event'));
        }else{
            $this->event->setProfileWithKeyAndValue('status', $this->event_status);
        }

        if (!$this->hasError()) {
            try {
                // get category entity
                $category = $this->em->find('Champs\Entity\Category', $this->category_id);
                $this->event->category = $category;
                
                $this->_eventRepository->storeEventEntity($this->event, $this->_user_id);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}