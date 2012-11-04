<?php
/**
 * Description of IndexController
 *
 * @author RyanChan
 */
class IndexController extends Zend_Controller_Action{
    public function indexAction(){
        $this->view->hello = 'Hello';
    }
}