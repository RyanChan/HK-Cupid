<?php

/**
 * Description of Security
 *
 * @author RyanChan
 */
class Champs_Form_Account_Security extends Champs_FormProcessor {

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
            $this->secure_browsing = $this->user->getProfile('secure_browsing');
            $this->login_notification_email = $this->user->getProfile('login_notification_email');
            $this->login_notification_sms = $this->user->getProfile('login_notification_sms');
        }
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // secure browsing
        $this->secure_browsing = $this->sanitize($request->getPost('secure_browsing'));

        if ($this->secure_browsing >= 0) {
            $this->user->setProfileWithKeyAndValue('secure_browsing', $this->secure_browsing);
        }

        // login notification email
        $this->login_notification_email = $this->sanitize($request->getPost('login_notification_email'));

        if ($this->login_notification_email >= 0) {
            $this->user->setProfileWithKeyAndValue('login_notification_email', $this->login_notification_email);
        }

        // login notification sms
        $this->login_notification_sms = $this->sanitize($request->getPost('login_notification_sms'));

        if ($this->login_notification_sms >= 0) {
            $this->user->setProfileWithKeyAndValue('login_notification_sms', $this->login_notification_sms);
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
