<?php

/**
 * Create an productPhoto
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_ProductPhoto_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of ProductPhoto
     *
     * @var Champs\Entity\Repository\ProductPhotoRepository $_productPhotoRepository
     */
    private $_productPhotoRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of ProductPhoto
     *
     * @var Champs\Entity\ProductPhoto $productPhoto
     */
    public $productPhoto = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_productPhotoRepository = $this->em->getRepository('Champs\Entity\ProductPhoto');

        // initialize productPhoto entity
        $this->productPhoto = new Champs\Entity\ProductPhoto();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // productPhoto filepath
        $this->productPhoto_filepath = $this->sanitize($request->getPost('productPhoto_filepath'));
        if(strlen($this->productPhoto_filepath) == 0){
            $this->addError('productPhoto_filepath', $this->translator->_('Please enter the productPhoto filepath'));
        }else{
            $this->productPhoto->filepath = $this->productPhoto_filepath;
        }
        
        // productPhoto description
        $this->productPhoto_description = $this->cleanHtml($request->getPost('productPhoto_description'));
        if(strlen($this->productPhoto_description) == 0){
            $this->addError('productPhoto_description', $this->translator->_('Please enter the productPhoto description'));
        }else{
            $this->productPhoto->description = $this->productPhoto_descriptiont;
        }
        
        // productPhoto user
        $user = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->productPhoto->user = $user;
        
        // product id
        $this->product_id = $request->getPost('product_id');
        if($this->product_id <= 0){
            $this->addError('product_id', $this->translator->_('Product id must greater than 0'));
        }else{
            $product = $this->em->find('Champs\Entity\Product', $this->product_id);
            $this->productPhoto->product = $product;
        }
        
        //Profile
            //code here

        if (!$this->hasError()) {
            try {
                $this->_productPhotoRepository->storeProductPhotoEntity($this->productPhoto);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}