<?php

class Champs_Form_Resource_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\ResourceRepository $_resourceRepository
     */
    private $_resourceRepository = null;
    
    /**
     * @var Champs\Entity\Resource $resource
     */
    public $resource = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_resourceRepository = $this->em->getRepository('Champs\Entity\Resource');
        $this->resource = new Champs\Entity\Resource();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        //resource actions (Array Collection)
            //code here
        
        // resource resourcename
        $this->resource_resourcename = $this->sanitize($request->getPost('resource_resourcename'));
        if(strlen($this->resource_resourcename) == 0){
            $this->addError('resource_resourcename', $this->translator->_('Please enter resource resourcename'));
        } else {
            $this->resource->resourcename = $this->resource_resourcename;
        }
        
        if (!$this->hasError()) {
            try {
                $this->_resourceRepository->storeResourceEntity($this->resource);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}