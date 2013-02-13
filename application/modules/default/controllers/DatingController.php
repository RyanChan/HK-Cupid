<?php

/**
 * Dating Controller
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class DatingController extends Champs_Controller_MasterController {

    /**
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    /**
     * Initialize methods
     */
    public function init() {
        parent::init();

        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
        $this->breadcrumb->addStep(
                $this->translator->_('Dating', $this->defaultLocale), $this->getUrl(null, 'dating')
        );
    }

    /**
     * Index action
     *
     * forward to browse action
     */
    public function indexAction() {
//        $this->_redirect($this->getUrl('browse'));

    }

    /**
     * Browse action
     */
    public function browseAction() {
        $view = $this->request->getParam('view') != null ? $this->request->getParam('view') : '';
        $page = (int) $this->request->getParam('page') > 1 ? $this->request->getParam('page') : 1;

        switch ($view) {
            case 'newest':
                $users = $this->userRepository->getNewestUsers();
                break;
            case 'hottest':
                $users = $this->userRepository->getHottestUsers();
                break;
            case 'active':
                $users = $this->userRepository->getActiveUsers();
                break;
            default:
                $view = 'member';
                $users = $this->userRepository->getNewestUsers();
        }

        //print_r( $users);

        $this->view->page = $page;
        $this->view->view = $view;
        $this->view->users = $users;

        $this->breadcrumb->addStep(
                $this->translator->_('Browse', $this->defaultLocale),
                $this->getUrl('browse', 'dating')
        )->addStep(
                $this->translator->_(sprintf('All %s', ucfirst($view)), $this->defaultLocale)
        );

        // get hash
        $this->initHash();
    }

    /**
     * Online action
     */
    public function onlineAction() {
        $view = $this->request->getParam('view');
        $page = $this->request->getParam('page');

        switch ($view) {
            case 'male':
                $users = $this->userRepository->getUsersByGender(Champs\Entity\Repository\UserRepository::MALE);
                break;
            case 'female':
                $users = $this->userRepository->getUsersByGender(Champs\Entity\Repository\UserRepository::FEMALE);
                break;
            default:
                $view = $this->identity->gender == Champs\Entity\Repository\UserRepository::MALE ? 'female' : 'male';
                $gender = $this->identity->gender == Champs\Entity\Repository\UserRepository::MALE ? Champs\Entity\Repository\UserRepository::FEMALE : Champs\Entity\Repository\UserRepository::MALE;
                $users = $this->userRepository->getUsersByGender($gender);
                break;
        }

        $this->view->users = $users;
        $this->view->page = $page;
        $this->view->view = $view;

        $this->breadcrumb->addStep(
                $this->translator->_('Browse', $this->defaultLocale),
                $this->getUrl('browse', 'dating')
        )->addStep(
                $this->translator->_(sprintf('All Online %s', ucfirst($view)), $this->defaultLocale)
        );

        // get hash
        $this->initHash();
    }

    /**
     * User action
     */
    public function userAction() {
        $username = $this->request->getParam('username');
        if (strlen($username) == 0)
            $this->_redirect($this->getUrl('index'));

        try {
            $user = $this->userRepository->getUserByUsername($username);
            $notFound = false;
        } catch (Exception $e) {
            $notFound = true;
        }

        $this->view->user = $user;
        $this->view->notFound = $notFound;

        $this->breadcrumb->addStep(
                $this->translator->_('Users', $this->defaultLocale),
                $this->getUrl(null, 'dating')
        )->addStep(
                $this->translator->_($username, $this->defaultLocale)
        );

        // get hash
        $this->initHash();
    }

    /**
     * Add follower
     */
    public function addfollowerAction() {
        // disable renderer
//        $this->setDisableLayout();
        $this->setNoRender();

        // get the request object
        $request = $this->getRequest();

        // target username
        $username = $request->getParam('username');

        if (strlen($username) <= 0) {
//            echo $user_id;
            throw new Exception('Non-Authorized Access');
        }

        // add follower
//        $user = $this->em->find('Champs\Entity\User', $user_id);
        $user = $this->userRepository->getUserByUsername($username);
        $result = $this->userRepository->addFollower($user);

        if ($result) {
            $url = sprintf('dating/user/%s', $username);
            $this->_redirect($url);
        } else {
            throw new Exception('Fail to add follower');
        }
    }

}