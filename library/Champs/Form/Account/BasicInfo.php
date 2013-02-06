<?php

/**
 * Description of BasicInfo
 *
 * @author RyanChan
 */
class Champs_Form_Account_BasicInfo extends Champs_FormProcessor {

    /**
     *
     * @var Champs\Entity\Repsoitory\UserRepsoitory $userRepository
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
            $this->birthday = $this->user->getProfile('birthday');
            $this->birthday_format = $this->user->getProfile('birthday_format');

            $this->gender = $this->user->getProfile('gender');
            $this->blood_type = $this->user->getProfile('blood_type');
            $this->interested_in = $this->user->getProfile('interested_in');
        }
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // birthday
        $this->birthdayMonth = $this->sanitize($request->getPost('birthday_Month'));
        $this->birthdayDay = $this->sanitize($request->getPost('birthday_Day'));
        $this->birthdayYear = $this->sanitize($request->getPost('birthday_Year'));

        $this->birthday = mktime(0, 0, 0, $this->birthdayMonth, $this->birthdayDay, $this->birthdayYear);

        if (checkdate($this->birthdayMonth, $this->birthdayDay, $this->birthdayYear))
            $this->user->setProfileWithKeyAndValue('birthday', $this->birthday);

        // birthday format
        $this->birthday_format = $this->sanitize($request->getPost('birthday_format'));

        if (strlen($this->birthday_format) <= 0) {
            $this->addError('birthday_format', $this->translator->_('Please select date format'));
        } else {
            $this->user->setProfileWithKeyAndValue('birthday_format', $this->birthday_format);
        }

        // gender
        $this->gender = $this->sanitize($request->getPost('gender'));

        if ($this->gender < 1 || $this->gender > 2)
            $this->addError('gender', $this->translator->_('Please select your gender'));
        else
            $this->user->setProfileWithKeyAndValue('gender', $this->gender);

        // blood type
        $this->blood_type = $this->sanitize($request->getPost('blood_type'));

        if (strlen($this->blood_type) > 0) {
            $this->user->setProfileWithKeyAndValue('blood_type', $this->blood_type);
        }

        // interested in
        $this->interested_in = $this->sanitize($request->getPost('interested_in'));

        if (strlen($this->interested_in) > 0) {
            $this->user->setProfileWithKeyAndValue('interested_in', $this->interested_in);
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
