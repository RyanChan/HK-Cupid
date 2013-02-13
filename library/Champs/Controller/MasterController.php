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
     *
     * @var Zend_Controller_Request_Abstract $request
     */
    protected $request;

    /**
     * User's identity class
     *
     * @var stdClass $identity
     */
    protected $identity;

    /**
     * Bootstrap object
     *
     * @var Bootstrap $bootstrap
     */
    protected $bootstrap;

    /**
     * Check if the request is Ajax
     *
     * @var boolean $isXHR
     */
    protected $isXHR;

    /**
     *
     * @var Zend_Translate $translator
     */
    protected $translator;

    /**
     *
     * @var string $defaultLocale
     */
    protected $defaultLocale;

    /**
     *
     * @var Champs_Breadcrumb $breadcrumb
     */
    protected $breadcrumb;

    /**
     * initialize method
     */
    public function init() {
        $this->em = Zend_Registry::get('doctrine')->getEntityManager();
        $this->request = $this->getRequest();
        $this->bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $this->isXHR = $this->request->isXmlHttpRequest();
        $this->translator = Zend_Registry::get('translate');
        $this->defaultLocale = key(Zend_Locale::getDefault());

        $this->breadcrumb = new Champs_Breadcrumb();
        $this->breadcrumb->addStep($this->translator->_('Home', $this->defaultLocale), $this->getUrl(null, 'index'));

        $this->defaultLocale = Zend_Locale::getDefault();

        $this->_initAuth();
        $this->_initACL();
    }

    protected function getUrl($action = null, $controller = null) {
        $url = $this->getRequest()->getBaseUrl();
        $url .= $this->_helper->url->simple($action, $controller);

        return $url;
    }

    /**
     * initialize auth object
     */
    private function _initAuth() {
        $this->auth = Zend_Auth::getInstance();
        $this->auth->setStorage(new \Zend_Auth_Storage_Session());
    }

    /**
     * initialize acl object
     */
    private function _initACL() {
        $this->acl = new Champs_Acl_Acl($this->auth);
    }

    /**
     * preDispatch method
     */
    public function preDispatch() {
        // check ACL before everything have executed
        $this->acl->checkACL($this->getRequest());

        // check whether user logged in or not
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->authenticated = true;
            $this->view->identity = $auth->getIdentity();
            $this->identity = $auth->getIdentity();
        } else
            $this->view->authenticated = false;

        // config object
        $config = $this->bootstrap->getResource('config');
        $this->view->config = $config;
    }

    /**
     * postDispatch method
     */
    public function postDispatch() {
        // get the controller & action name for the active navigation menu
        $this->view->controller = $this->getRequest()->getControllerName();
        $this->view->action = $this->getRequest()->getActionName();

        $this->view->breadcrumb = $this->breadcrumb;
        $this->view->title=  $this->breadcrumb->getTitle();
    }

    /**
     * Short cut helper of setNoRender
     */
    public function setNoRender() {
        $this->_helper->viewRenderer->setNoRender();
    }

    /**
     * Short cut helper of disable layout
     */
    public function setDisableLayout() {
        $this->_helper->layout()->disableLayout();
    }

    /**
     * Redirect to user's album
     *
     * @param string $nickname
     * @param integer $album_id
     */
    public function redirectToAlbum($nickname, $album_id) {
        $url = sprintf('%s/albums/%d/photos', $nickname, $album_id);
        $this->_redirect($url);
    }

    /**
     * Validate the hash
     *
     * @param string $hash
     */
    public function checkHash($hash) {
        $session_hash = new Zend_Session_Namespace('hash');
        if ($session_hash->hash == $hash)
            return true;
        else
            return false;
    }

    /**
     * Init hash
     */
    public function initHash() {
        $session_hash = new Zend_Session_Namespace('hash');
        $session_hash->setExpirationSeconds(900);
        $session_hash->hash = md5(uniqid(time()));

        // assign hash to view
        $this->view->hash = $session_hash->hash;
    }

    public function throwPageNotFound() {
        $this->_throwError('Page Not Found');
    }

    private function _throwError($message = null) {
        throw new Exception($message);
    }

    public function sendJson($data) {
        $this->setNoRender();

        $this->getResponse()->setHeader('content-type', 'application/json');
        echo Zend_Json::encode($data);
    }

    public function imagefile($id, $w, $h) {
        $id = isset($id) ? $id : 0;
        $w = isset($w) ? $w : 0;
        $h = isset($h) ? $h : 0;

        $hash = Champs\Entity\Photo::GetImageHash($id, $w, $h);

        return sprintf('%s?id=%d&w=%d&h=%d&hash=%s',
//                    $this->getUrl('image', 'utility'),
                        '/utility/image', $id, $w, $h, $hash
        );
    }

}