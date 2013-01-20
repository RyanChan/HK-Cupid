<?php
/**
 * Description of IndexController
 *
 * @author RyanChan
 */
class IndexController extends Champs_Controller_MasterController {

    /**
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    public function init(){
        parent::init();

        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
    }

    public function indexAction() {
        $users = $this->userRepository->getNewestUsers(0, 4);

        // assign users to view
        $this->view->users = $users;
        // get hash
        $this->initHash();
    }

}