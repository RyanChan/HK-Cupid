<?php

/**
 * Description of General
 *
 * @author RyanChan
 */
class Champs_Form_Account_General extends Champs_FormProcessor {

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
            $this->first_name = $this->user->getProfile('first_name');
            $this->last_name = $this->user->getProfile('last_name');
            $this->email = $this->user->getProfile('email');
            $this->locale = $this->user->getProfile('locale');
        }
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // first name
        $this->first_name = $this->sanitize($request->getPost('first_name'));
        if (strlen($this->first_name) <= 0) {
            $this->addError('first_name', $this->translator->_('Please enter your first name'));
        } else {
            $this->user->setProfileWithKeyAndValue('first_name', $this->first_name);
        }
        // last name
        $this->last_name = $this->sanitize($request->getPost('last_name'));

        if (strlen($this->last_name) <= 0) {
            $this->addError('last_name', $this->translator->_('Please enter your last name'));
        } else {
            $this->user->setProfileWithKeyAndValue('last_namr', $this->last_name);
        }
        // current password
        $this->current_password = $request->getPost('current_password');

        if (strlen($this->current_password) > 0 && $this->user->isCurrentPassword($this->current_password)) {
            $this->new_password = $request->getPost('new_password');
            $this->retype_password = $request->getPost('retype_password');

            if (strlen($this->new_password) <= 0 || strlen($this->retype_password) <= 0) {
                $this->addError('wrong_password', $this->translator->_('New password fields can not be blank'));
            } else if ($this->new_password !== $this->retype_password) {
                $this->addError('wrong_password', $this->translator->_('Two passwords were not matched.'));
            } else {
                $this->user->setPassword($this->current_password);
            }
        }

        // locale
        $this->locale = $this->sanitize($request->getPost('locale'));

        if (strlen($this->locale) > 0)
            $this->user->setProfileWithKeyAndValue('locale', $this->locale);


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