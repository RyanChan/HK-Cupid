<?php

/**
 * Dating Controller
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class DatingController extends Champs_Controller_MasterController{
    /**
     * __construct methods
     */
    public function __construct(){
        parent::__construct();
    }
    /**
     * Index action
     *
     * forward to browse action
     */
    public function indexAction(){
        $this->_forward('browse');
    }
    /**
     * Browse action
     */
    public function browseAction(){

    }
    /**
     * Online action
     */
    public function onlineAction(){

    }
}