<?php

/**
 * Description of Notification
 *
 * @author RyanChan
 */
class Champs_Form_Account_Notification extends Champs_FormProcessor {

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
            $this->receive_all_notification_on_web = $this->user->getProfile('receive_all_notification_on_web');
            $this->receive_all_notification_by_email = $this->user->getProfile('receive_all_notification_by_email');
        }
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // notification on web
        $this->receive_all_notification_on_web = $this->sanitize($request->getPost('receive_all_notification_on_web'));

        if ($this->receive_all_notification_on_web >= 0) {
            $this->user->setProfileWithKeyAndValue('receive_all_notification_on_web', $this->receive_all_notification_on_web);
        }

        // notification by email
        $this->receive_all_notification_by_email = $this->sanitize($request->getPost('receive_all_notification_by_email'));

        if ($this->receive_all_notification_by_email >= 0) {
            $this->user->setProfileWithKeyAndValue('receive_all_notification_by_email', $this->receive_all_notification_by_email);
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
