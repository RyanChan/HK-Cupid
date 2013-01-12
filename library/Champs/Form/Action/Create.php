<?php

class Champs_Form_Action_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\ActionRepository $_actionRepository
     */
    private $_actionRepository = null;
    
    /**
     * @var Champs\Entity\Action $action
     */
    public $action = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_actionRepository = $this->em->getRepository('Champs\Entity\Action');
        $this->action = new Champs\Entity\Action();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        
        // actionname
        $this->action_name = $this->sanitize($request->getPost('action_name'));
        if(strlen($this->action_name) == 0){
            $this->addError('action_name', $this->translator->_('Please enter action name'));
        } else {
            $this->action->actionname = $this->action_name;
        }
        
        // resource id
        $this->resource_id = $request->getPost('resource_id');
        if($this->resource_id < 0){
            $this->addError('resource_id', $this->translator->_('Resource id must greater than 0'));
        }
        
        if (!$this->hasError()) {
            try {
                $resource = $this->em->find('Champs\Entity\Resource', $this->resource_id);
                $this->action->resource = $resource;
                $this->_actionRepository->storeActionEntity($this->action);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}