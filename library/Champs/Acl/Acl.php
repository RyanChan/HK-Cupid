<?php
/**
 * Acl plugin
 * @author RyanChan
 */
class Champs_Acl_Acl {

    /**
     *
     * @var string $_defaultRole
     */
    private $_defaultRole = 'Guest';

    /**
     *
     * @var array $_authController
     */
    private $_authController = array('controller' => 'account', 'action' => 'login', 'module' => 'account');

    /**
     *
     * @var Doctrine\ORM\EntityManager $_em
     */
    private $_em = null;

    /**
     * Initialize Champs\Acl\Acl class
     *
     * @param Zend_Auth $auth
     */
    public function __construct(Zend_Auth $auth) {

        $this->auth = $auth;
        $this->acl = new Zend_Acl();

        $this->_em = Zend_Registry::get('doctrine')->getEntityManager();

        // add the different user roles
        $roles = $this->_em->getRepository('Champs\Entity\Role')->findAll();
//        $this->acl->addRole(new Zend_Acl_Role($this->_defaultRole));
        if (null !== $roles) {
            foreach ($roles as $role) {
                $this->acl->addRole(new Zend_Acl_Role($role->rolename));
            }
        }

        // add the resources we want to have control over
        $resources = $this->_em->getRepository('Champs\Entity\Resource')->findAll();
//        $this->acl->addResource(new Zend_Acl_Resource('index'));
        if (null !== $resources) {
            foreach ($resources as $resource) {
                $this->acl->addResource(new Zend_Acl_Resource($resource->resourcename));
            }
        }

        // allow access to everything far all users by default
        $this->acl->deny();

        $authorizations = $this->_em->getRepository('Champs\Entity\Authorization')->findAll();

        foreach ($authorizations as $authorization) {
            $this->acl->allow(
                    $authorization->role->rolename,
                    $authorization->resource->resourcename,
                    $authorization->action->actionname
            );
        }
    }

    /**
     * preDispatch
     *
     * Before an action is dispatched, check if the current user
     * has sufficient privileges. If not, dispatch the default
     * action instead
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function checkACL(Zend_Controller_Request_Abstract $request) {
        // check if a user is logged in and has a valid role,
        // otherwise, assign them the default role(guest)
        if ($this->auth->hasIdentity()) {
            $role = @$this->auth->getIdentity()->rolename;
        } else {
            $role = $this->_defaultRole;
        }

        if (!$this->acl->hasRole($role))
            $role = $this->_defaultRole;

        // the ACL resource is the requested controller name
        $resource = $request->controller;
        // the ACL privilege is the requested action name
        $privilege = $request->action;

        // if we haven't explicitly added the resource, check
        // the default global permissions
        if (!$this->acl->has($resource))
            $resource = null;

        // access denied - reroute the request to the default action handler
        if (!$this->acl->isAllowed($role, $resource, $privilege)){
            $request->setControllerName(($this->_authController['controller']));
            $request->setActionName($this->_authController['action']);
            $request->setModuleName($this->_authController['module']);
        }
    }

}