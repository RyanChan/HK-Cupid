<?php
/**
 * Description of IndexController
 *
 * @author RyanChan
 */
class IndexController extends Champs_Controller_MasterController {

    /**
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    /**
     *
     * @var Champs\Entity\Repository\AlbumRepository $albumRepository
     */
    protected $albumRepository = null;

    /**
     *
     * @var Champs\Entity\Repository\ProductRepository $productRepository
     */
    protected $productRepository = null;

    /**
     *
     * @var Champs\Entity\Repository\PhotoRepository $photoRepository
     */
    protected $photoRepository = null;

    public function init(){
        parent::init();

        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
        $this->albumRepository = $this->em->getRepository('Champs\Entity\Album');
        $this->productRepository = $this->em->getRepository('Champs\Entity\Product');
        $this->photoRepository = $this->em->getRepository('Champs\Entity\Photo');
    }

    public function indexAction() {
        $users = $this->userRepository->getNewestUsers(0, 4);
        $albums = $this->albumRepository->getNewestAlbums(0, 4);
        $products = $this->productRepository->getNewestProduct(0, 4);
        $photos = $this->photoRepository->getPhotos();

        // assign users to view
        $this->view->users = $users;
        // assign albums to view
        $this->view->albums = $albums;
        // assign products to view
        $this->view->products = $products;
        // assign photos to view
        $this->view->photos = $photos;
        // get hash
        $this->initHash();
    }

}