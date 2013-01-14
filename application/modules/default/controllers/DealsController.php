<?php

/**
 * Description of DealsController
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class DealsController extends Champs_Controller_MasterController implements Champs_Controller_Interface_CRUDInterface{

    /**
     *
     * @var Champs\Entity\Repository\ProductRepository $productRepository
     */
    protected $productRepository = null;

    /**
     * initialize controller
     */
    public function init(){
        parent::init();
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
        $user = $this->productRepository->

        // assign nickname to view
        $this->view->nickname = $nickname;
    }

    /**
     * product Action
     *
     * single product details
     */
    public function productAction() {

    }

    /**
     * create action
     *
     * create a product
     */
    public function createAction() {

    }

    /**
     * edit Action
     *
     * edit a product
     */
    public function editAction() {

    }

    /**
     * delete Action
     *
     * delete a product
     */
    public function deleteAction() {

    }

    /**
     * payments Action
     *
     * list out all the payments of the current user
     */
    public function paymentsAction() {

    }

    /**
     * payment Action
     *
     * show up the single payment
     */
    public function paymentAction () {

    }


}
