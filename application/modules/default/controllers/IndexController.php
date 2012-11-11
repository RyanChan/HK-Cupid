<?php
/**
 * Description of IndexController
 *
 * @author RyanChan
 */
class IndexController extends Zend_Controller_Action{
    public function indexAction(){
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        $this->view->user = $em->getRepository('Champs\Entity\User')->isValidUsername('kimchan1314');
    }
}