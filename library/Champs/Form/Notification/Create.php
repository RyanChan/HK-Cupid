<?php

/**
 * Create an notification
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Notification_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Notification
     *
     * @var Champs\Entity\Repository\NotificationRepository $_notificationRepository
     */
    private $_notificationRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Notification
     *
     * @var Champs\Entity\Notification $notification
     */
    public $notification = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_notificationRepository = $this->em->getRepository('Champs\Entity\Notification');

        // initialize notification entity
        $this->notification = new Champs\Entity\Notification();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // notification receivers (Array Collection)
            //code here
        
        // notification sender
        $sender = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->notification->sender = $sender;
        
        // notification message
        $this->notification_message = $this->cleanHtml($request->getPost('notification_message'));
        if(strlen($this->notification_message) == 0){
            $this->addError('notification_message', $this->translator->_('Please enter notification message'));
        } else {
            $this->notification->message = $this->notification_message;
        }
        
        // notification targetType
        $this->notification_targetType = $this->sanitize($request->getPost('notification_targetType'));
        if(strlen($this->notification_targetType) == 0){
            $this->addError('notification_targetType', $this->translator->_('Please enter notification targetType'));
        } else {
            $this->notification->targetType = $this->notification_targetType;
        }
        
        // notification targetEntity
        $this->notification_targetEntity = $request->getPost('notification_targetEntity');
        $this->notification->targetEntity = $this->notification_targetEntity;

        if (!$this->hasError()) {
            try {
                $this->_notificationRepository->storeNotificationEntity($this->notification);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}