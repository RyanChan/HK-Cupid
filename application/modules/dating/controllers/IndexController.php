<?php
/**
 * Description of IndexController
 *
 * @author RyanChan
 */
class Dating_IndexController extends Zend_Controller_Action{
    public function indexAction(){
        $this->view->hello = 'Yo';
    }
}