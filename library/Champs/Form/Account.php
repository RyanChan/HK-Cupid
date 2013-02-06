<?php

/**
 * Description of Account
 *
 * @author RyanChan
 */
class Champs_Form_Account extends Champs_FormProcessor{
    /**
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    /**
     *
     * @var Champs\Entity\User $user
     */
    public $user = null;

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    protected function process(\Zend_Controller_Request_Abstract $request) {

    }
}
