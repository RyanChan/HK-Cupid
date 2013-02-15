<?php

/**
 * Album Controller
 */
class AlbumController extends Champs_Controller_MasterController implements Champs_Controller_Interface_CRUDInterface {

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

    /**
     * User's repository
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    public function init() {
        parent::init();
        $this->breadcrumb->addStep('Album', $this->getUrl(null, 'album'));

        $this->albumRepository = $this->em->getRepository('Champs\Entity\Album');
        $this->photoRepository = $this->em->getRepository('Champs\Entity\Photo');
        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
        
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addalbumcomment', 'json')
                    ->addActionContext('deletealbumcomment', 'json')
                    ->addActionContext('addphotocomment', 'json')
                    ->addActionContext('deletephotocomment', 'json')
                    ->addActionContext('albumlike', 'json')
                    ->addActionContext('albumunlike', 'json')
                    ->addActionContext('photolike', 'json')
                    ->addActionContext('photounlike', 'json')
                    ->initContext();
    }

    /**
     * indexAction
     *
     * forward to brose action
     */
    public function indexAction() {
        $this->_forward('browse');

        $this->breadcrumb->addStep('Browse');
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
                    $this->redirectToAlbum($this->identity->username, $form->album->id);
                }
            }
        }

        // setup hash
        $this->initHash();

        $this->view->form = $form;
        $this->breadcrumb->addStep('Create');
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
        $username = $request->getParam('username');

        // form object
        $form = new Champs_Form_Album_Edit($album);

        if ($request->isPost()) {
            // get the hash
            $hash = $request->getPost('hash');

            if ($this->checkHash($hash)) {
                if ($form->process($request)) {
                    $this->redirectToAlbum($username, $album_id);
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
        $this->view->username = $username;

        $this->breadcrumb->addStep('Edit');
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
        $this->breadcrumb->addStep('Delete');
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
        // get hash
        $this->initHash();
        $this->breadcrumb->addStep('Browse');
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
        $user_id = @$this->identity->user_id;
        // assign isOwner to view
        $this->view->isOwner = $album->user->id == $user_id;
        // assign album id to view
        $this->view->album_id = $album_id;
        // assign photos to view
        $this->view->photos = $album->photos;
        // assign album to view
        $this->view->album = $album;
        // get hash
        $this->initHash();

        $this->breadcrumb->addStep($album->user->username, sprintf('/dating/user/%s', $album->user->username))
                         ->addStep('Photos');
    }

    /**
     * albumsAction
     *
     * browse user's albums
     */
    public function albumsAction() {
        // get the request object
        $request = $this->getRequest();
        // get the nickname
        $username = $request->getParam('username');

        $albums = $this->albumRepository->getAlbumsForCurrentUser();

        $isOwner = $username == @$this->identity->nickname;

        // assign isOwner to view
        $this->view->isOwner = $isOwner;
        // assign nickname to view
        $this->view->nickname = $username;
        // assign albums to view
        $this->view->albums = $albums;
        // get hash
        $this->initHash();
        $this->breadcrumb->addStep($username, sprintf('/dating/user/%s', $username))
                         ->addStep('Albums');
//        $this->breadcrumb->addStep('Albums');
    }

    /**
     * uploadAction
     *
     * upload photo to current album
     */
    public function uploadAction() {
        // get the request object
//        $request = $this->getRequest();

        $album_id = $this->_request->getParam('id');

        if ($this->_request->isOptions()) {
            $this->upload($this->identity->user_id, $album_id, $this->identity->email);
        }

        if ($this->_request->isPost()) {
            $this->upload($this->identity->user_id, $album_id, $this->identity->email);
        }

        if ($this->_request->isGet()) {
            $this->upload($this->identity->user_id, $album_id, $this->identity->email);
        }

        if ($this->_request->isDelete() || $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $photo_id = $this->_request->getParam('photoid');

            $this->delete($this->identity->user_id, $album_id, $photo_id, $this->identity->email);
        }

        exit;

        /*
          if ($request->isPost()) {

          // get the album id
          $album_id = $request->getParam('id');

          if ($album_id > 0) {
          // get the album entity
          $album = $this->albumRepository->findOneBy(array('id' => $album_id)); //find('Champs\Entity\Album', $album_id);

          if (!$album) {
          $this->redirectToAlbum($this->identity->username, $album_id);
          }

          $form = new Champs_Form_Album_Upload($album);

          if ($form->process($request)) {
          $this->redirectToAlbum($this->identity->username, $album_id);
          } else {
          $this->redirectToAlbum($this->identity->username, $album_id);
          }
          } else {
          $this->redirectToAlbum($this->identity->username, $album_id);
          }
          } else {
          $this->redirectToAlbum($this->identity->username, $album_id);
          }
         */
    }

    public function upload($user_id, $album_id, $email) {
        if ($user_id && $email && $album_id) {
            $adapter = new Zend_File_Transfer_Adapter_Http();

            $album = $this->albumRepository->find($album_id);
            if (!$album) {
                return;
            }

            if ($album->user->id != $user_id && $this->identity->email != $email) {
                return;
            }

//            $photo = new Champs\Entity\Photo();

            $datas = array();

            $adapter->setDestination($album->getAlbumFolder());
            $adapter->addValidator('Extension', false, 'jpg,png,gif');

            $files = $adapter->getFileInfo();
            foreach ($files as $file => $info) {

                if (!$adapter->isUploaded($file))
                    continue;
                if (!$adapter->isValid($file))
                    continue;

                $name = $adapter->getFileName();

//                // create a photo entity
                $photo = new Champs\Entity\Photo();
                $photo->filepath = basename($name);
                $photo->description = basename($name);
                $photo->album = $album;
                $photo->user = $album->user;
//
                $this->em->persist($photo);
                $this->em->flush();
//
                $adapter->addFilter('rename', $photo->getFullPath());

                $adapter->receive($file);

                $fileClass = new stdClass();
                $fileClass->name = str_replace($album->getAlbumFolder(), 'New Image Upload Complete:   ', $name);
                $fileClass->size = $adapter->getFileSize($file);
                $fileClass->type = $adapter->getMimeType($file);
                $delete_url = sprintf('/album/upload/id/%d/photoid/%d', $album_id, $photo->id);
                $fileClass->delete_url = $delete_url;
                $fileClass->delete_type = 'DELETE';
                $fileClass->url = $this->imagefile($photo->id, 200, 0);
                $fileClass->thumbnail_url = $this->imagefile($photo->id, 200, 0);
//                $fileClass->error = true;

                $datas['files'][] = $fileClass;
            }

            header('Pragma: no-cache');
            header('Cache-Control: private, no-cache');
            header('Content-Disposition: inline; filename="files.json"');
            header('X-Content-Type-Options: nosniff');
            header('Vary: Accept');
            echo Zend_Json::encode($datas);
//            echo $datas['files'][0]->url;
        }
    }

    public function delete($user_id, $album_id, $photo_id, $email) {
        if ($user_id && $email && $album_id && $photo_id) {
            // check whether photo exists
            $query = $this->em->createQuery("SELECT p
                                             FROM Champs\Entity\Photo p, Champs\Entity\Album a, Champs\Entity\User u, Champs\Entity\UserProfile up
                                             WHERE p.album = a and a.user = u and p.user = u and up.user = u and u.id = ?1 and up.profile_key = 'email' and up.profile_value = ?2 and p.id = ?3 and a.id = ?4");
            $query->setParameter(1, $user_id)->setParameter(2, $email)->setParameter(3, $photo_id)->setParameter(4, $album_id);

            $photo = $query->getSingleResult();

            if (!$photo) return;

            $this->em->remove($photo);
            $this->em->flush();
        }
    }

    /**
     * Delete photo action
     */
    public function deletephotoAction() {
        // get the request object
        $request = $this->getRequest();
        // get the nickname
        $username = $request->getParam('username');
        // get the album id
        $album_id = $request->getParam('album_id');
        // get the photo id
        $photo_id = $request->getParam('id');

        // remove photo
        $this->albumRepository->removePhoto($album_id, $photo_id);
        $this->redirectToAlbum($username, $album_id);
    }

    public function addalbumcommentAction(){
        
    }
    
    public function deletealbumcommentAction(){
        
    }
    
    public function addphotocommentAction(){
        
    }
    
    public function deletephotocommentAction(){
        
    }
    
    public function albumlikeAction(){
        
    }
    
    public function albumunlikeAction(){
        
    }
    
    public function photolikeAction(){
        
    }
    
    public function photounlikeAction(){
        
    }
    
    public function getphotosAction(){
        
    }
}