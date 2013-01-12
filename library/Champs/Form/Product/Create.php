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
        
        $this->_paymentRepository = $this->em->getRepository('Champs\Entity\Product');
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
        
        // product ranking
        $this->product_ranking = $request->getPost('product_ranking');
        if($this->product_ranking < 0){
            $this->addError('product_ranking', $this->translator->_('Ranking must greater than -1'));
        } else {
            $this->product->ranking = $this->product_ranking;
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