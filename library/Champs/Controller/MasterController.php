<?php

namespace Champs\Controller;

class MasterController extends \Zend_Controller_Action {

    /**
     *
     * @var Zend_Auth $auth
     */
    protected $auth;

    /**
     *
     * @var Champs\Acl\Acl $acl
     */
    protected $acl;

    /**
     * initialize method
     */
    public function init() {
        $this->_initAuth();
        $this->_initACL();
    }

    /**
     * initialize auth object
     */
    private function _initAuth(){
        $this->auth = \Zend_Auth::getInstance();
        $this->auth->setStorage(new \Zend_Auth_Storage_Session());
    }

    /**
     * initialize acl object
     */
    private function _initACL(){
        $this->acl = new \Champs\Acl\Acl($this->auth);
    }

    /**
     * preDispatch method
     */
    public function preDispatch(){
        // check ACL before everything have executed
        $this->acl->checkACL($this->getRequest());
    }
}