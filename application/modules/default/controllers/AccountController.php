<?php

class AccountController extends Champs_Controller_MasterController {

    /**
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    /**
     * Initialize method
     */
    public function init() {
        parent::init();

        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
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
            // get the hash
            $hash = $request->getPost('hash');

            if ($this->checkHash($hash)) {
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
        }

        // setup hash
        $this->initHash();

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
            // get the hash
            $hash = $request->getPost('hash');

            if ($this->checkHash($hash)) {
                if ($fp->process($request)) {
                    $session = new Zend_Session_Namespace('registration');
                    $session->user_id = $fp->user->id;
                    $this->_redirect($this->getUrl('complete'));
                }
            }
        }

        // setup hash
        $this->initHash();
        // assign form to view
        $this->view->fp = $fp;
    }

    /**
     * Complete action of account controller
     *
     * show up the message that if the user completed registration process
     */
    public function completeAction() {
        // setup hash
        $this->initHash();
    }

    /**
     * Reset password action of account controller
     *
     * show up the form for reset user's password
     */
    public function resetpasswordAction() {
        // setup hash
        $this->initHash();
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
            // get the hash
            $hash = $request->getPost('hash');

            if ($this->checkHash($hash)) {
                if ($form->process($request)) {
                    $this->_redirect($this->getUrl('details'));
                }
            }
        }

        // setup hash
        $this->initHash();

        $user = $this->em->find('Champs\Entity\User', $identity->user_id);
        $this->view->user = $user;
        $this->view->form = $form;
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
        // get hash
        $this->initHash();
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
        // get hash
        $this->initHash();
    }

    public function settingsAction() {
        // get user id
        $user_id = $this->identity->user_id;
        // get user entity
        $user = $this->userRepository->find($user_id);

        // assign user to view
        $this->view->user = $user;

        // get hash
        $this->initHash();
    }

    public function generalAction() {
        $request = $this->getRequest();

        if (!$request->isPost() || !$this->checkHash($request->getPost('hash'))) {
            $this->throwPageNotFound();
        }

        $form = new Champs_Form_Account_General($this->identity->user_id);

        if ($form->process($request)) {
            $this->_redirect('/account/settings');
        }

        $this->view->form = $form;
    }

    /**
     * profileAction function.
     *
     * @access public
     * @return void
     */
    public function profileAction() {
        $request = $this->getRequest();

        if (!$request->isPost() || !$this->checkHash($request->getPost('hash'))) {
            $this->throwPageNotFound();
        }

        $form = new Champs_Form_Account_Profile($this->identity->user_id);

        if ($form->process($request)) {
            $this->_redirect('/account/settings');
        }

        $this->view->form = $form;
    }

}