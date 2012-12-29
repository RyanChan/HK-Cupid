<?php

/**
 * Doctrine's authenticate class
 *
 * @author RyanChan
 *
 */
class Champs_Auth_Doctrine implements Zend_Auth_Adapter_Interface {

    const NOT_FOUND_MSG = 'Account not found';
    const BAD_PW_MSG = 'Username or password is invalid';

    /**
     *
     * @var string $password
     */
    protected $password = '';

    /**
     *
     * @var string $username
     */
    protected $username = '';

    /**
     * Initialize with username and password
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Defined by Zend_Auth_Adapter_Interface. This method is called to
     * attempt an authentication. Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws Zend_Auth_Adater_Exception if answering the authentication query is impossible
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        try {
            $userRepository = Zend_Registry::get('doctrine')->getEntityManager()->getRepository('Champs\Entity\User');
            $user = $userRepository->authenticate($this->username, $this->password);
        } catch (Exception $e) {
            if ($e->getMessage() == Champs\Entity\Repository\UserRepository::NOT_FOUND)
                return $this->_createResult(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null, array(self::NOT_FOUND_MSG));

            if ($e->getMessage() == Champs\Entity\Repository\UserRepository::WRONG_PW)
                return $this->_createResult(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, null, array(self::BAD_PW_MSG));
        }

        return $this->_createResult(Zend_Auth_Result::SUCCESS, $user);
    }

    /**
     * Returns Zend_Auth_Result object
     *
     * @param string $code
     * @param array|string $message
     * @return \Zend_Auth_Result
     */
    private function _createResult($code, $object, $message = array()) {
        return new Zend_Auth_Result($code, $object, $message);
    }

}