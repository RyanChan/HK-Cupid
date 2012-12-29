<?php

class AccountController extends Champs_Controller_MasterController {

    /**
     * Initialize method
     */
    public function init() {
        parent::init();
    }

    /**
     * Index action of account controller
     *
     * show up all the information of the user
     *
     * forward to profile page instead
     */
    public function indexAction() {
        $this->_forward('profile');
    }

    /**
     * logoutAction function.
     *
     * @access public
     * @return void
     */
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
            $this->_redirect($this->getUrl('login'));
        } else {
            $this->_redirect($this->getUrl());
        }
    }

    /**
     * Login action of account controller
     *
     * show up the login page
     */
    public function loginAction() {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $this->_redirect($this->getUrl());
        }

        $request = $this->getRequest();

        $redirect = $request->getPost('redirect');
        if (strlen($redirect) == 0)
            $redirect = $request->getServer('REQUEST_URI');
        if (strlen($redirect) == 0)
            $redirect = $this->getUrl();

        $errors = array();

        if ($request->isPost()) {

            $username = $request->getPost('username');
            $password = $request->getPost('password');

            if (strlen($username) == 0 || strlen($password) == 0)
                $errors['username'] = 'Required field must not be blank';

            if (count($errors) == 0) {
                $adapter = new Champs_Auth_Doctrine($username, $password);

                $result = $auth->authenticate($adapter);

                if ($result->isValid()) {
                    $this->_redirect($this->getUrl());
                }

                $errors['username'] = 'Your login details were invalid';
            }
        }

        $this->view->errors = $errors;
        $this->view->redirect = $redirect;
    }

    /**
     * Register action of account controller
     *
     * show up the registration form
     */
    public function registerAction() {
        $request = $this->getRequest();

        $fp = new Champs_Form_Account_Register($this->em);

        if ($request->isPost()) {
            if ($fp->process($request)) {
                $session = new Zend_Session_Namespace('registration');
                $session->user_id = $fp->user->id;
                $this->_redirect($this->getUrl('complete'));
            }
        }

        $this->view->fp = $fp;
    }

    /**
     * Complete action of account controller
     *
     * show up the message that if the user completed registration process
     */
    public function completeAction() {

    }

    /**
     * Reset password action of account controller
     *
     * show up the form for reset user's password
     */
    public function resetpasswordAction() {

    }

    /**
     * detailsAction function.
     *
     * @access public
     * @return void
     */
    public function detailsAction() {
        $identity = Zend_Auth::getInstance()->getIdentity();

        $form = new Champs_Form_Account_Details($identity->user_id);
        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->process($request)) {
                $this->_redirect($this->getUrl('details'));
            }
        }

        $user = $this->em->find('Champs\Entity\User', $identity->user_id);
        $this->view->user = $user;
        $this->view->form = $form;
    }

    /**
     * profileAction function.
     *
     * @access public
     * @return void
     */
    public function profileAction() {

    }

    /**
     * Confirm and activate user account
     */
    public function confirmAction() {
        if (Zend_Auth::getInstance()->hasIdentity())
            $this->_redirect($this->getUrl());

        $errors = array();

        $action = $this->getRequest()->getParam('a');

        switch ($action) {
            case 'email':
                $id = $this->getRequest()->getParam('id');
                $key = $this->getRequest()->getParam('key');

                $result = $this->em->getRepository('Champs\Entity\User')->activateAccount($id, $key);

                if (!$result) {
                    $errors['email'] = 'Error activating your account';
                }

                break;
        }

        $this->view->errors = $errors;
        $this->view->action = $action;
    }

    public function authAction() {
        $identity = Zend_Auth::getInstance()->getIdentity();

        //$form = new Champs_Form_Account_Details($identity->user_id);
        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->process($request)) {
                $this->_redirect($this->getUrl('details'));
            }
        }

        $user = $this->em->find('Champs\Entity\User', $identity->user_id);
        $this->view->user = $user;
        //$this->view->form = $form;
    }

    public function settingsAction() {
        
    }

}