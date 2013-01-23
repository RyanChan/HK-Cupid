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
     *
     * @var Champs\Entity\Repository\UserRepository $userRepository
     */
    protected $userRepository = null;

    /**
     * initialize controller
     */
    public function init() {
        parent::init();

        $this->productRepository = $this->em->getRepository('Champs\Entity\Product');
        $this->userRepository = $this->em->getRepository('Champs\Entity\User');
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
                $products = $this->productRepository->getNewestProduct();
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
        // get user entity
        $user = $this->userRepository->getUserByNickname($nickname);
        // get current user products
        $products = $this->productRepository->getProductsByUser($user);

        $isOwner = $nickname == @$this->identity->nickname;

        // assign isOwner to view
        $this->view->isOwner = $isOwner;
        // assign products to view
        $this->view->products = $products;
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
        // get request object
        $request = $this->getRequest();
        // get product id
        $product_id = $request->getParam('id');
        // product entity
        $product = $this->productRepository->find($product_id);

        // assign isOwner to view
        $this->view->isOwner = ($product->user->id == @$this->identity->user_id);

        // assign product to view
        $this->view->product = $product;
        // get hash
        $this->initHash();
    }

    /**
     * create action
     *
     * create a product
     */
    public function createAction() {
        // get the request
        $request = $this->getRequest();

        // create product form
        $form = new Champs_Form_Product_Create();

        if ($request->isPost()) {
            if ($form->process($request)) {
                $redirect = sprintf('%s/products', $this->identity->nickname);
                $this->_redirect($redirect);
            }
        }

        // assign form to view
        $this->view->form = $form;

        // get hash
        $this->initHash();
    }

    /**
     * edit Action
     *
     * edit a product
     */
    public function editAction() {
        // get the request object
        $request = $this->getRequest();
        // get the product id
        $product_id = $this->request->getParam('id');
        // get the product entity
        $product = $this->productRepository->find($product_id);

        // init the form object
        $form = new Champs_Form_Product_Edit($product);

        if ($request->isPost()) {
            if ($form->process($request)) {
                $redirect = sprintf('%s/products/%d', $this->identity->nickname, $product_id);
                $this->_redirect($redirect);
            }
        }

        // assign product_id to view
        $this->view->product_id = $product_id;
        // assign product to view
        $this->view->product = $product;
        // assign form to view
        $this->view->form = $form;

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
