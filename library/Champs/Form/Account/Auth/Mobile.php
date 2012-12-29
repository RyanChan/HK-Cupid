<?php

class Champs_Form_Account_Auth_Mobile extends Champs_Form_Account_Auth{
    /**
     * Constructor
     *
     * @param integer $user_id
     */
    public function __construct($user_id = 0){
        parent::__construct($user_id);
    }
    /**
     * Process
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function process(Zend_Controller_Request_Abstract $request){
        // mobile number
        $this->mobile_number = $this->sanitize($request->getPost('mobile_number'));

        
    }
}