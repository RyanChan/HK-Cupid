<?php

use Champs\Controller\MasterController;

/**
 * Description of IndexController
 *
 * @author RyanChan
 */
class IndexController extends MasterController {

    public function init(){
        parent::init();
    }

    public function indexAction() {
        $this->view->defaultLocale = Zend_Registry::get('translate')->getList();
    }

}