<?php

/**
 * Description of SetupController
 *
 * @author RyanChan
 */
class SetupController extends Champs_Controller_MasterController {

    public function init() {
        parent::init();
    }

    public function indexAction() {

    }

    public function setupAction() {
        //        $this->setNoRender();
        // get front controller
        $front = $this->getFrontController();
        $acl = array();
        foreach ($front->getControllerDirectory() as $module => $path) {
            foreach (scandir($path) as $file) {
                if (strstr($file, 'Controller.php') !== false) {
                    include_once $path . DIRECTORY_SEPARATOR . $file;
                    foreach (get_declared_classes() as $class) {
                        if (is_subclass_of($class, 'Zend_Controller_Action')) {
                            $controller = strtolower(substr($class, 0, strpos($class, 'Controller')));
                            $actions = array();

                            foreach (get_class_methods($class) as $action) {
                                if (strstr($action, 'Action') !== false) {
                                    $actions[] = str_replace('Action', '', $action);
                                }
                            }
                        }
                    }
                    $acl[$module][$controller] = $actions;
                }
            }
        }

        foreach ($acl as $module => $controllers) {
//            echo $module;
            foreach ($controllers as $r => $actions) {
//                echo $r;

                $resource = new Champs\Entity\Resource();
                $resource->resourcename = $r;

                $this->em->persist($resource);
                $this->em->flush();

                foreach ($actions as $action) {
//                    echo $action;

                    $privilege = new \Champs\Entity\Action();
                    $privilege->actionname = $action;
                    $privilege->resource = $resource;

                    $this->em->persist($privilege);
                    $this->em->flush();
                }
            }
        }
    }

    public function roleAction() {
        $roles = array();
        $roles[] = 'Administrator';
        $roles[] = 'SuperVIP';
        $roles[] = 'VIP';
        $roles[] = 'Member';
        $roles[] = 'Guest';

        foreach ($roles as $role) {
            $r = new Champs\Entity\Role();
            $r->rolename = $role;

            $this->em->persist($r);

        }
        $this->em->flush();
    }

    public function authorizationAction() {
//        // for administrator
//        $query1 = $this->em->createQuery("SELECT r FROM Champs\Entity\Role r WHERE r.rolename = ?1");
//        $query1->setParameter(1, 'Member');
//
//        $admin = $query1->getSingleResult();
//
//        $query = $this->em->createQuery("SELECT r FROM Champs\Entity\Resource r WHERE r.resourcename != ?1");
//        $query->setParameter(1, 'administration');
//        $resources = $query->getResult();
//
//        foreach ($resources as $resource) {
//            foreach ($resource->actions as $action) {
//                $authorize = new Champs\Entity\Authorization();
//                $authorize->resource = $resource;
//                $authorize->action = $action;
//                $authorize->role = $admin;
//
//                $this->em->persist($authorize);
//            }
//        }
//
//        $this->em->flush();
//        $this->view->resources = $resources;
        // for member
        // for guest
        $query = $this->em->createQuery("SELECT r FROM Champs\Entity\Role r WHERE r.rolename = ?1");
        $query->setParameter(1, 'Guest');

        $guest = $query->getSingleResult();

        $query1 = $this->em->createQuery("SELECT r FROM Champs\Entity\Resource r");
//        $query1->setParameter(1, 'index')->setParameter(2, 'account');

        $resources = $query1->getResult();

        $this->view->resources = $resources;

        foreach ($resources as $resource) {
            if ($resource->resourcename == 'index') {
                foreach ($resource->actions as $action) {
                    $authorize = new Champs\Entity\Authorization();
                    $authorize->resource = $resource;
                    $authorize->action = $action;
                    $authorize->role = $guest;

                    $this->em->persist($authorize);
                }
            } else if ($resource->resourcename == 'account') {
                foreach ($resource->actions as $action) {
                    if ($action->actionname == 'register' ||
                            $action->actionname == 'login' ||
                            $action->actionname == 'confirm' ||
                            $action->actionname == 'complete') {
                        $authorize = new Champs\Entity\Authorization();
                        $authorize->resource = $resource;
                        $authorize->action = $action;
                        $authorize->role = $guest;

                        $this->em->persist($authorize);
                    }
                }
            }
        }

        $this->em->flush();
    }

}
