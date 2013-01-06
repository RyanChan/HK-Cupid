<?php

/**
 * Profile Form
 *
 * @author RyanChan
 */
class Champs_Form_Account_Details extends Champs_FormProcessor {

    /**
     *
     * @var Champs\Entity\Repository\UserRepository $_userRepository
     */
    private $_userRepository;

    /**
     *
     * @var Champs\Entity\User $user
     */
    public $user;

    /**
     *
     * @param integer $user_id
     */
    public function __construct($user_id = 0) {
        parent::__construct();

        $this->_userRepository = Zend_Registry::get('doctrine')->getEntityManager()->getRepository('Champs\Entity\User');
        $this->user = $this->_userRepository->find($user_id);
    }

    public function process(\Zend_Controller_Request_Abstract $request) {
        // email address
        $this->email = $this->sanitize($request->getPost('email'));
        $validator = new Zend_Validate_EmailAddress();

        if (strlen($this->email) == 0)
            $this->addError('email', 'Please enter your e-mail address');
        else if (!$validator->isValid($this->email))
            $this->addError('email', 'Please enter a valid e-mail address');
        else
            $this->user->setProfileWithKeyAndValue('email', $this->email);

        // nickname
        $this->nickname = $this->sanitize($request->getPost('nickname'));

        if (strlen($this->nickname) > 0)
            $this->user->setProfileWithKeyAndValue('nickname', $this->nickname);

        // gender
        $this->gender = $this->sanitize($request->getPost('gender'));

        if ($this->gender < 1 || $this->gender > 2)
            $this->addError('gender', 'Please select your gender');
        else
            $this->user->setProfileWithKeyAndValue('gender', $this->gender);

        // birthday
        $this->birthdayMonth = $this->sanitize($request->getPost('birthday_Month'));
        $this->birthdayDay = $this->sanitize($request->getPost('birthday_Day'));
        $this->birthdayYear = $this->sanitize($request->getPost('birthday_Year'));

        $this->birthday = mktime(0, 0, 0, $this->birthdayMonth, $this->birthdayDay, $this->birthdayYear);

        if (checkdate($this->birthdayMonth, $this->birthdayDay, $this->birthdayYear))
            $this->user->setProfileWithKeyAndValue('birthday', $this->birthday);

        // relationship
        $this->relationship = $this->sanitize($request->getPost('relationship'));

        if (is_numeric($this->relationship))
            $this->user->setProfileWithKeyAndValue('relationship', $this->relationship);

        // bodytype
        $this->bodytype = $this->sanitize($request->getPost('bodytype'));

        if (is_numeric($this->bodytype))
            $this->user->setProfileWithKeyAndValue('bodytype', $this->bodytype);

        // living situation
        $this->living_situation = $this->sanitize($request->getPost('house_tag'));

        if (is_numeric($this->living_situation))
            $this->user->setProfileWithKeyAndValue('house_tag', $this->living_situation);

        // smoking
        $this->smoking = $this->sanitize($request->getPost('smoking'));

        if (is_numeric($this->smoking))
            $this->user->setProfileWithKeyAndValue('smoking', $this->smoking);

        // drinking
        $this->drinking = $this->sanitize($request->getPost('drinking'));

        if (is_numeric($this->drinking))
            $this->user->setProfileWithKeyAndValue('drinking', $this->drinking);

        // resting habit
        $this->resting = $this->sanitize($request->getPost('resting'));

        if (is_numeric($this->resting))
            $this->user->setProfileWithKeyAndValue('resting', $this->resting);

        // car tag
        $this->cartag = $this->sanitize($request->getPost('cartag'));

        if (is_numeric($this->cartag))
            $this->user->setProfileWithKeyAndValue('cartag', $this->cartag);

        // max consume
        $this->maxconsume = $this->sanitize($request->getPost('maxconsume'));

        if (is_numeric($this->maxconsume))
            $this->user->setProfileWithKeyAndValue('maxconsume', $this->maxconsume);

        // romance
        $this->romance = $this->sanitize($request->getPost('romance'));

        if (is_numeric($this->romance))
            $this->user->setProfileWithKeyAndValue('romance', $this->romance);

        // location
        $this->location = $this->sanitize($request->getPost('location'));

        if (strlen($this->location) > 0)
            $this->user->setProfileWithKeyAndValue('location', $this->location);

        // mobile
        $this->mobile = $this->sanitize($request->getPost('mobile'));

        if (strlen($this->mobile) == 0)
            $this->addError('mobile', 'Please enter your mobile number');
        else
            $this->user->setProfileWithKeyAndValue('mobile', $this->mobile);

        // education
        $this->education = $this->sanitize($request->getPost('education'));

        if (strlen($this->education) < 0)
            $this->addError('education', 'Please select your education level');
        else
            $this->user->setProfileWithKeyAndValue('education', $this->education);

        // personal income
        $this->personal_income = $this->sanitize($request->getPost('personalincome'));

        if (strlen($this->personal_income) >= 0)
            $this->user->setProfileWithKeyAndValue('personalincome', $this->personal_income);

        // profession
        $this->profession = $this->sanitize($request->getPost('profession'));

        if (strlen($this->profession) >= 0)
            $this->user->setProfileWithKeyAndValue('profession', $this->profession);

        // occupation
        $this->occupation = $this->sanitize($request->getPost('occupation'));

        if (strlen($this->occupation) >= 0)
            $this->user->setProfileWithKeyAndValue('occupation', $this->occupation);

        // intro
        $this->intro = $this->cleanHtml($request->getPost('intro'));

        if (strlen($this->intro) > 0)
            $this->user->setProfileWithKeyAndValue('intro', $this->intro);

        if (!$this->hasError()) {
            try {
                $this->_userRepository->updateUserEntity();
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}