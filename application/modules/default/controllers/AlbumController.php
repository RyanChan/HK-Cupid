<?php

/**
 * Album Controller
 */
class AlbumController extends Champs_Controller_MasterController {

    public function init() {
        parent::init();
    }

    /**
     * indexAction
     *
     * forward to brose action
     */
    public function indexAction() {
        $this->_forward('browse');
    }

    /**
     * createAction
     *
     * create an album for user
     */
    public function createAction() {

    }

    /**
     * editAction
     *
     * edit an album of user
     */
    public function editAction() {

    }

    /**
     * deleteAction
     *
     * delete an album
     */
    public function deleteAction() {

    }

    /**
     * browseAction
     *
     * browse all the albums
     */
    public function browseAction() {

    }

    /**
     * photosAction
     *
     * browse specific album's photos
     */
    public function photosAction() {

    }

    /**
     * albumsAction
     *
     * browse user's albums
     */
    public function albumsAction() {

    }

}