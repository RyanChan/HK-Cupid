<?php

class Champs_Form_Role_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\RoleRepository $_roleRepository
     */
    private $_roleRepository = null;
    
    /**
     * @var Champs\Entity\Role $role
     */
    public $role = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_roleRepository = $this->em->getRepository('Champs\Entity\Role');
        $this->role = new Champs\Entity\Role();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // role rolename
        $this->role_rolename = $this->sanitize($request->getPost('role_rolename'));
        if(strlen($this->role_rolename) == 0){
            $this->addError('role_rolename', $this->translator->_('Please enter role rolename'));
        } else {
            $this->role->rolename = $this->role_rolename;
        }
        
        if (!$this->hasError()) {
            try {
                $this->_roleRepository->storeRoleEntity($this->role);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}