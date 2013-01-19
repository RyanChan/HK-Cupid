<?php

/**
 * Description of DealsController
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class DealsController extends Champs_Controller_MasterController implements Champs_Controller_Interface_CRUDInterface {

    /**
     *
     * @var Champs\Entity\Repository\ProductRepository $productRepository
     */
    protected $productRepository = null;

    /**
     * initialize controller
     */
    public function init() {
        parent::init();

        $this->productRepository = $this->em->getRepository('Champs\Entity\Product');
    }

    /**
     * Browse Action
     *
     * forward to index action
     */
    public function browseAction() {
        $this->_forward('index');
    }

    /**
     * Index Action
     */
    public function indexAction() {
        // get the request object
        $request = $this->getRequest();
        // get the view mode
        $view = $request->getParam('view');

        switch ($view) {
            case 'newest':
                $products = $this->productRepository->getNewestProduct();
                break;
            case 'hottest':
                $products = $this->productRepository->getHottestProduct();
                break;
            case 'featured':
//                $products = $this->productRepository->getFeaturedProduct();
                break;
            default:
                break;
        }

        // assign view to view
        $this->view->view = $view;
        // assign products to view
        $this->view->products = $products;
        // get hash
        $this->initHash();
    }

    /**
     * products Action
     *
     * User's products listing
     */
    public function productsAction() {
        // get the request object
        $request = $this->getRequest();
        // get the nickname
        $nickname = $request->getParam('nickname');
        // get user entity by nickname
//        $user = $this->productRepository->
        // assign nickname to view
        $this->view->nickname = $nickname;
        // get hash
        $this->initHash();
    }

    /**
     * product Action
     *
     * single product details
     */
    public function productAction() {
        // get hash
        $this->initHash();
    }

    /**
     * create action
     *
     * create a product
     */
    public function createAction() {

        // get hash
        $this->initHash();
    }

    /**
     * edit Action
     *
     * edit a product
     */
    public function editAction() {
        // get hash
        $this->initHash();
    }

    /**
     * delete Action
     *
     * delete a product
     */
    public function deleteAction() {
        // get hash
        $this->initHash();
    }

    /**
     * payments Action
     *
     * list out all the payments of the current user
     */
    public function paymentsAction() {
        // get hash
        $this->initHash();
    }

    /**
     * payment Action
     *
     * show up the single payment
     */
    public function paymentAction() {
        // get hash
        $this->initHash();
    }

}
