<?php

class Champs_Form_Account_Auth_HKID extends Champs_Form_Account_Auth {

    /**
     * HKID value list
     *
     * @var array $_list
     */
    private $_list = array(
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        'a' => 10,
        'b' => 11,
        'c' => 12,
        'd' => 13,
        'e' => 14,
        'f' => 15,
        'g' => 16,
        'h' => 17,
        'i' => 18,
        'j' => 19,
        'k' => 20,
        'l' => 21,
        'm' => 22,
        'n' => 23,
        'o' => 24,
        'p' => 25,
        'q' => 26,
        'r' => 27,
        's' => 28,
        't' => 29,
        'u' => 30,
        'v' => 31,
        'w' => 32,
        'x' => 33,
        'y' => 34,
        'z' => 35
    );

    /**
     * Constructor
     *
     * @param integer $user_id
     */
    public function __construct($user_id = 0) {
        parent::__construct($user_id);
    }

    /**
     * Process
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function process(Zend_Controller_Request_Abstract $request) {
        // hkid
        $this->hkid = $this->sanitize($request->getPost('hkid'));
    }

    private function _checkHKID($hkid) {
        $id = array();

        for ($i = 0; $i < strlen($hkid); $i++) {
            $char = $hkid[i];
            if (is_string($char)) {
                $char = strtolower($char);
                $id[i] = $this->_list[$char];
            } else if (is_numeric($char)) {
                $id[i] = $this->_list[$char];
            }
        }


    }

}