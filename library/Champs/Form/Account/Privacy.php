<?php

/**
 * Description of Privacy
 *
 * @author RyanChan
 */
class Champs_Form_Account_Privacy extends Champs_FormProcessor {

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
     * @param integer $user_id
     */
    public function __construct($user_id = 0) {
        parent::__construct();

        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
        $this->user = $this->userRepository->find($user_id);

        if ($this->user) {
            $this->public_search = $this->user->getProfile('public_search');
            $this->send_message_permission = $this->user->getProfile('send_message_permission');
        }
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // public search
        $this->public_search = $this->sanitize($request->getPost('public_search'));

        if($this->public_search >= 0) {
            $this->user->setProfileWithKeyAndValue('public_search', $this->public_search);
        }

        // send message permission
        $this->send_message_permission = $this->sanitize($request->getPost('send_message_permission'));

        if ($this->send_message_permission >= 0) {
            $this->user->setProfileWithKeyAndValue('send_message_permission', $this->send_message_permission);
        }

        if(!$this->hasError()) {
            try{
                $this->em->flush();
        }catch (Exception $e) {
            $this->addError('fatal_error', $e->getMessage());
        }
        }

        return !$this->hasError();
    }

}
