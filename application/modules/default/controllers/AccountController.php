<?php

class AccountController extends Champs_Controller_MasterController{
    /**
     * Initialize method
     */
    public function init(){
        parent::init();
    }

    /**
     * Index action of account controller
     *
     * show up all the information of the user
     */
    public function indexAction(){

    }

    /**
     * Login action of account controller
     *
     * show up the login page
     */
    public function loginAction(){
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()){
            $this->_redirect($this->getUrl());
        }

        $request = $this->getRequest();

        $redirect = $request->getPost('redirect');
        if (strlen($redirect) == 0)
            $redirect = $request->getServer('REQUEST_URI');
        if (strlen($redirect) == 0)
            $redirect = $this->getUrl ();

        $errors = null;

        if ($request->isPost()){
            $errors = array();
            $username = $request->getPost('username');
            $password = $request->getPost('password');

            if (strlen($username) == 0 || strlen($password) == 0)
                $errors['username'] = 'Required field must not be blank';

            if (count($errors) == 0){
                $adapter = new Champs_Auth_Doctrine($username, $password);

                $result = $auth->authenticate($adapter);

                if ($result->isValid()){
                    $user = $adapter->getUser();

                    $identity = $user;

                    $auth->getStorage()->write($identity);

                    $this->_redirect($redirect);
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
    public function registerAction(){
        $request = $this->getRequest();

        $fp = new Champs_Form_Account_Register($this->em);

        if ($request->isPost()){
            if ($fp->process($request)){
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
    public function completeAction(){
        
    }

    /**
     * Reset password action of account controller
     *
     * show up the form for reset user's password
     */
    public function resetpasswordAction(){

    }

    public function profileAction(){

    }
}