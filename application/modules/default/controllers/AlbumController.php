<?php

/**
 * Album Controller
 */
class AlbumController extends Champs_Controller_MasterController {

    /**
     * Album's repository
     *
     * @var Champs\Entity\Repository\AlbumRepository $albumRepository
     */
    protected $albumRepository = null;

    /**
     * Photo's repository
     *
     * @var Champs\Entity\Repository\PhotoRepository $photoRepository
     */
    protected $photoRepository = null;

    public function init() {
        parent::init();

        $this->albumRepository = $this->em->getRepository('Champs\Entity\Album');
        $this->photoRepository = $this->em->getRepository('Champs\Entity\Photo');
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
        $request = $this->getRequest();

        $form = new Champs_Form_Album_Create();

        if ($request->isPost()) {
            if ($form->process($request)) {
                $redirectURL = sprintf('%s/albums/%d/photos', $this->identity->nickname, $form->album->id);
                $this->_redirect($redirectURL);
            }
        }

        $this->view->form = $form;
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
     * browse all the albums or photos
     */
    public function browseAction() {

    }

    /**
     * photosAction
     *
     * browse specific album's photos
     */
    public function photosAction() {
        // get the request object
        $request = $this->getRequest();
        // get the album id
        $album_id = $request->getParam('id');
        // get the album entity
        $album = $this->albumRepository->find($album_id);
        // get the user id
        $user_id = $this->identity->user_id;
        // assign isOwner to view
        $this->view->isOwner = $album->user->id == $user_id;
        // assign album id to view
        $this->view->album_id = $album_id;
        // assign photos to view
        $this->view->photos = $album->photos;
        // assign album to view
        $this->view->album = $album;
    }

    /**
     * albumsAction
     *
     * browse user's albums
     */
    public function albumsAction() {
        $albums = $this->albumRepository->getAlbumsForCurrentUser();

        $this->view->albums = $albums;
    }

    /**
     * uploadAction
     *
     * upload photo to current album
     */
    public function uploadAction() {
        // get the request object
        $request = $this->getRequest();

        if ($request->isPost()) {

            // get the album id
            $album_id = $request->getParam('id');

            if ($album_id > 0) {
                // get the album entity
                $album = $this->albumRepository->findOneBy(array('id' => $album_id));//find('Champs\Entity\Album', $album_id);

                if (!$album) {
                   $redirectURL = sprintf('%s/albums/%d/photos', $this->identity->nickname, $album_id);
                   $this->_redirect($redirectURL);
                }

                $form = new Champs_Form_Album_Upload($album);

                if ($form->process($request)) {
                    $redirectURL = sprintf('%s/albums/%d/photos', $this->identity->nickname, $album_id);
                    $this->_redirect($redirectURL);
                } else {
                    $redirectURL = sprintf('%s/albums/%d/photos', $this->identity->nickname, $album_id);
                    $this->_redirect($redirectURL);
                }
            } else {
                $redirectURL = sprintf('%s/albums/%d/photos', $this->identity->nickname, $album_id);
                $this->_redirect($redirectURL);
            }
        } else {
            $redirectURL = sprintf('%s/albums/%d/photos', $this->identity->nickname, $album_id);
            $this->_redirect($redirectURL);
        }
    }

}