<?php

/**
 * Description of DealsController
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class DealsController extends Champs_Controller_MasterController{

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
                break;
            case 'hottest':
                break;
            case 'featured':
                break;
            default:
                break;
        }

        $this->view->view = $view;
    }

    /**
     * products Action
     *
     * User's products listing
     */
    public function productsAction() {

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
