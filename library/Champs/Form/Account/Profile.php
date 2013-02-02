<?php

/**
 * Description of Profile
 *
 * @author RyanChan
 */
class Champs_Form_Account_Profile extends Champs_FormProcessor {

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
            $this->intro = $this->user->getProfile('intro');
        }
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // user's intro
        $this->intro = $this->cleanHtml($request->getPost('intro'));

        if (strlen($this->intro) > 0) {
            $this->user->setProfileWithKeyAndValue('intro', $this->intro);
        }

        if (!$this->hasError()) {
            try {
                $this->em->flush();
            } catch (Exception $e) {
                $this->addError('fatal_error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}
