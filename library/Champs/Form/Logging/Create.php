<?php

/**
 * Create an logging
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Logging_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Logging
     *
     * @var Champs\Entity\Repository\LoggingRepository $_loggingRepository
     */
    private $_locationRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Logging
     *
     * @var Champs\Entity\Logging $logging
     */
    public $logging = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_loggingRepository = $this->em->getRepository('Champs\Entity\Logging');

        // initialize logging entity
        $this->logging = new Champs\Entity\Logging();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // logging activity
        $this->logging_activity = $this->cleanHtml($request->getPost('logging_activity'));

        if (strlen($this->logging_activity) == 0){
            $this->addError('logging_activity', $this->translator->_('Please enter the logging activity'));
        } else {
            $this->logging->activity = $this->logging_activity;
        }
        
        // logging level
        $this->logging_level = $this->getPost('logging_level');
        
        if($this->logging_level < 0){
            $this->addError('logging_level', $this->translator->_('Logging level must greater than 0'));
        }else{
            $this->logging->level = $this->logging_levell
        }
        

        if (!$this->hasError()) {
            try {
                $this->_loggingRepository->storeLoggingEntity($this->logging, $this->_user_id);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}