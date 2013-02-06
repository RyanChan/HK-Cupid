<?php

class Champs_Form_Account_Register extends Champs_FormProcessor {

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
     * Initialize method
     *
     */
    public function __construct() {
        parent::__construct();

        $this->_userRepository = Zend_Registry::get('doctrine')->getEntityManager()->getRepository('Champs\Entity\User');
        $this->user = new Champs\Entity\User();
    }

    public function process(\Zend_Controller_Request_Abstract $request) {
        // email address
        $this->email = $this->sanitize($request->getPost('email'));
        $validator = new Zend_Validate_EmailAddress();

        if (strlen($this->email) == 0)
            $this->addError('email', $this->translator->_('Please enter your e-mail address', $this->locale));
        else if (!$validator->isValid($this->email))
            $this->addError('email', $this->translator->_('Please enter a valid e-mail address', $this->locale));
        else if ($this->_userRepository->hasSameEmail($this->email))
            $this->addError ('email', $this->translator->_('Your email have been registered', $this->locale));
        else {
            $this->user->setUsername($this->email);
            $this->user->setProfileWithKeyAndValue('email', $this->email);
        }

        // first name
        $this->first_name = $this->sanitize($request->getPost('first_name'));

        if (strlen($this->first_name) == 0)
            $this->addError('first_name', $this->translator->_('Please enter your first name', $this->locale));
        else
            $this->user->setProfileWithKeyAndValue('first_name', $this->first_name);

        // last name
        $this->last_name = $this->sanitize($request->getPost('last_name'));

        if (strlen($this->last_name) == 0)
            $this->addError('last_name', $this->translator->_('Please enter your last name', $this->locale));
        else
            $this->user->setProfileWithKeyAndValue('last_name', $this->last_name);

        $this->password = $this->sanitize($request->getPost('password'));

        if (strlen($this->password) < 8)
            $this->addError('password', $this->translator->_('Please enter a password that is longer than 8 characters', $this->locale));
        else
            $this->user->setPassword($this->password);

        if (!$this->hasError()) {
            try {
                $this->_userRepository->storeUserEntity($this->user);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}