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
            // get the hash
            $hash = $request->getPost('hash');

            if ($this->checkHash($hash)) {
                if ($form->process($request)) {
                    $this->redirectToAlbum($this->identity->nickname, $form->album->id);
                }
            }
        }

        // setup hash
        $this->initHash();

        $this->view->form = $form;
    }

    /**
     * editAction
     *
     * edit an album of user
     */
    public function editAction() {
        // get the request object
        $request = $this->getRequest();
        // get the album id and entity
        $album_id = $request->getParam('id');
        $album = $this->em->find('Champs\Entity\Album', $album_id);
        // get the nickname
        $nickname = $request->getParam('nickname');

        // form object
        $form = new Champs_Form_Album_Edit($album);

        if ($request->isPost()) {
            // get the hash
            $hash = $request->getPost('hash');

            if ($this->checkHash($hash)) {
                if ($form->process($request)) {
                    $this->redirectToAlbum($nickname, $album_id);
                }
            }
        }

        // setup / refresh hash for security reason
        $this->initHash();

        // assign album id to view
        $this->view->album_id = $album_id;
        // assign form to view
        $this->view->form = $form;
        // assign nickname to vew
        $this->view->nickname = $nickname;
    }

    /**
     * deleteAction
     *
     * delete an album
     */
    public function deleteAction() {
        // get the request object
        $request = $this->getRequest();
        // get the album id
        $album_id = $request->getParam('id');
        // get the album entity
        $album = $this->em->find('Champs\Entity\Album', $album_id);
        // get the user entity
        $user = $this->em->find('Champs\Entity\User', $this->identity->user_id);
        // init delete
        $deleted = false;

        if ($album->user == $user) {
            $this->em->remove($album);
            $this->em->flush();
            $deleted = true;
        }

        $this->view->deleted = $deleted;
        $this->view->nickname = $this->identity->nickname;
    }

    /**
     * browseAction
     *
     * browse all the albums or photos
     */
    public function browseAction() {
        // get the request object
        $request = $this->getRequest();
        // get the view
        $view = $request->getParam('view');
        // initialize albums array
        $albums = array();

        switch ($view) {
            case 'newest':
                $albums = $this->albumRepository->getNewestAlbums();
                break;
            case 'hottest':
                $albums = $this->albumRepository->getHottestAlbums();
                break;
            case 'male':
                $albums = $this->albumRepository->getAlbumsByGender(Champs\Entity\Repository\UserRepository::MALE);
                break;
            case 'female':
                $albums = $this->albumRepository->getAlbumsByGender(Champs\Entity\Repository\UserRepository::FEMALE);
                break;
            default:
                $albums = $this->albumRepository->getAlbums();
                break;
        }

        // assign albums to view
        $this->view->albums = $albums;
        // assign view mode to view
        $this->view->view = $view;
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
                $album = $this->albumRepository->findOneBy(array('id' => $album_id)); //find('Champs\Entity\Album', $album_id);

                if (!$album) {
                    $this->redirectToAlbum($this->identity->nickname, $album_id);
                }

                $form = new Champs_Form_Album_Upload($album);

                if ($form->process($request)) {
                    $this->redirectToAlbum($this->identity->nickname, $album_id);
                } else {
                    $this->redirectToAlbum($this->identity->nickname, $album_id);
                }
            } else {
                $this->redirectToAlbum($this->identity->nickname, $album_id);
            }
        } else {
            $this->redirectToAlbum($this->identity->nickname, $album_id);
        }
    }

}