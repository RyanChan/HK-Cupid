<?php
/**
 * Account Authentication
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Account_Auth extends Champs_FormProcessor{
    /**
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    private $userRepository;
    /**
     *
     * @var Champs\Entity\User $user
     */
    public $user;
    /**
     * Constructor
     */
    public function __construct($user_id = 0) {
        parent::__construct();

        $this->userRepository = Zend_Registry::get('doctrine')->getEntityManager()->getRepository('Champs\Entity\User');
        $this->user = $this->userRepository->find($user_id);
    }
    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        
    }
}