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
    }

    /**
     * Index action
     *
     * forward to browse action
     */
    public function indexAction() {
        $this->_forward('browse');
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
                $users = $this->userRepository->getNewestUsers();
        }

        //print_r( $users);

        $this->view->page = $page;
        $this->view->view = $view;
        $this->view->users = $users;
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
                $gender = $this->identity->gender == Champs\Entity\Repository\UserRepository::MALE ? Champs\Entity\Repository\UserRepository::FEMALE : Champs\Entity\Repository\UserRepository::MALE;
                $users = $this->userRepository->getUsersByGender($gender);
                break;
        }

        $this->view->users = $users;
        $this->view->page = $page;
        $this->view->view = $view;
    }

    /**
     * User action
     */
    public function userAction() {
        $nickname = $this->request->getParam('nickname');
        if (strlen($nickname) == 0)
            $this->_redirect($this->getUrl('index'));

        try {
            $user = $this->userRepository->getUserByNickname($nickname);
            $notFound = false;
        } catch (Exception $e) {
            $notFound = true;
        }

        $this->view->user = $user;
        $this->view->notFound = $notFound;
    }

}