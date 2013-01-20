<?php

class Champs_Form_Product_Create extends Champs_FormProcessor {

    /**
     * @var Champs\Entity\Repository\ProductRepository $_productRepository
     */
    private $_productRepository = null;

    /**
     * @var Champs\Entity\Product $product
     */
    public $product = null;

    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();

        $this->_productRepository = $this->em->getRepository('Champs\Entity\Product');
        $this->product = new Champs\Entity\Product();
    }

    /**
     *
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {

        // product title
        $this->product_title = $this->sanitize($request->getPost('product_title'));

        if(strlen($this->product_title) == 0){
            $this->addError('product_title', $this->translator->_('Please enter product title'));
        } else {
            $this->product->title = $this->product_title;
        }

        // product status
        $this->product_status = $this->sanitize($request->getPost('product_status'));

        if ($this->product_status < 0) {
            $this->addError('product_status', $this->translator->_('Please select the status of product'));
        } else {
            $this->product->setProfileWithKeyAndValue('status', $this->product_status);
        }

        // product payment
        $this->product_payment = $this->sanitize($request->getPost('product_payment'));

        if ($this->product_payment < 0) {
            $this->addError('product_payment', $this->translator->_('Please select a payment method'));
        } else {
            $this->product->setProfileWithKeyAndValue('payment', $this->product_payment);
        }

        // product delivery
        $this->product_delivery = $this->sanitize($request->getPost('product_delivery'));

        if ($this->product_delivery < 0) {
            $this->addError('product_delivery', $this->translator->_('Please select a delivery method'));
        } else {
            $this->product->setProfileWithKeyAndValue('delivery', $this->product_delivery);
        }

        // product searchable
        $this->product_searchable = $this->sanitize($request->getPost('product_searchable'));

        if ($this->product_searchable < 0) {
            $this->addError('product_searchable', $this->translator->_('Please select searchable option'));
        } else {
            $this->product->setProfileWithKeyAndValue('searchable', $this->product_searchable);
        }

        // product quantity
        $this->product_quantity = $request->getPost('product_quantity');

        if(!is_numeric($this->product_quantity) && $this->product_quantity < 0){
            $this->addError('product_quantity', $this->translator->_('Quantity must greater than 0'));
        } else {
            $this->product->quantity = $this->product_quantity;
        }

        // product description
        $this->product_description = $this->cleanHtml($request->getPost('product_description'));

        if (strlen($this->product_description) == 0) {
            $this->addError('product_description', $this->translator->_('Please enter the description of the product'));
        } else {
            $this->product->setProfileWithKeyAndValue('description', $this->product_description);
        }

        // product price
        $this->product_price = $this->sanitize($request->getPost('product_price'));

        if ($this->product_price <= 0) {
            $this->addError('product_price', 'Please enter the price of product');
        } else {
            $this->product->price = $this->product_price;
        }

        if (!$this->hasError()) {
            try {
                $this->_productRepository->storeProductEntity($this->product);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }
}