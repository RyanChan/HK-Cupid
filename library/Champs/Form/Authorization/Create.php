<?php

/**
 * Create an authorization
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Authorization_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Authorization
     *
     * @var Champs\Entity\Repository\AuthorizationRepository $_authorizationRepository
     */
    private $_authorizationRepository = null;

    /**
     * Entity of Authorization
     *
     * @var Champs\Entity\Authorization $authorization
     */
    public $authorization = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_authorizationRepository = $this->em->getRepository('Champs\Entity\Authorization');

        // initialize authorization entity
        $this->authorization = new Champs\Entity\Authorization();
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        //resource id
        $this->resource_id = $request->getPost('resource_id');
        
        //action id
        $this->action_id = $request->getPost('action_id');
        
        //role id
        $this->role_id = $request->getPost('role');

        if (!$this->hasError()) {
            try {
                // get resource entity
                $resource = $this->em->find('Champs\Entity\Resource', $this->resource_id);
                $this->authorization->resource = $resource;
                
                // get action entity
                $action = $this->em->find('Champs\Entity\Action', $this->action_id);
                $this->authorization->action = $action;
                
                // get role entity
                $role = $this->em->find('Champs\Entity\Role', $this->role_id);
                $this->authorization->role = $role;
                
                $this->_authorizationRepository->storeAuthorizationEntity($this->authorization);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}