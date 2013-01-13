<?php

/**
 * CRUD interface
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
interface Champs_Controller_Interface_CRUDInterface {

    /**
     * Index action
     */
    public function indexAction();

    /**
     * Create action
     */
    public function createAction();

    /**
     * Edit action
     */
    public function editAction();

    /**
     * Delete action
     */
    public function deleteAction();
}