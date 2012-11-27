<?php
class Champs_Controller_MasterController extends Zend_Controller_Action {

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
     *
     * @var Doctrine\ORM\EntityManager $em
     */
    protected $em;

    /**
     * initialize method
     */
    public function init() {
        $this->em = Zend_Registry::get('doctrine')->getEntityManager();

        $this->_initAuth();
        $this->_initACL();
    }

    protected function getUrl($action = null, $controller = null){
        $url = rtrim($this->getRequest()->getBaseUrl(), '/').'/';
        $url .= $this->_helper->url->simple($action, $controller);

        return $url;
    }

    /**
     * initialize auth object
     */
    private function _initAuth(){
        $this->auth = Zend_Auth::getInstance();
        $this->auth->setStorage(new \Zend_Auth_Storage_Session());
    }

    /**
     * initialize acl object
     */
    private function _initACL(){
        $this->acl = new Champs_Acl_Acl($this->auth);
    }

    /**
     * preDispatch method
     */
    public function preDispatch(){
        // check ACL before everything have executed
        $this->acl->checkACL($this->getRequest());

        // check whether user logged in or not
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity())
            $this->view->authenticated = true;
        else
            $this->view->authenticated = false;
    }

    public function postDispatch() {
        // get the controller name for the active navigation menu
        $this->view->controller = $this->getRequest()->getControllerName();
    }

    /**
     * Short out helper of setNoRender
     */
    public function setNoRender(){
        $this->_helper->viewRenderer->setNoRender();
    }
}