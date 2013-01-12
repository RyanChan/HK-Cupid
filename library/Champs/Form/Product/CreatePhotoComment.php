<?php

/**
 * Create an productPhotoComment
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_ProductPhotoComment_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of ProductPhotoComment
     *
     * @var Champs\Entity\Repository\ProductPhotoCommentRepository $_productPhotoCommentRepository
     */
    private $_productPhotoCommentRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of ProductPhotoComment
     *
     * @var Champs\Entity\ProductPhotoComment $productPhotoComment
     */
    public $productPhotoComment = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_productPhotoCommentRepository = $this->em->getRepository('Champs\Entity\ProductPhotoComment');

        // initialize productPhotoComment entity
        $this->productPhotoComment = new Champs\Entity\ProductPhotoComment();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // productPhotoComment title
        $this->productPhotoComment_title = $this->sanitize($request->getPost('productPhotoComment_title'));
        if(strlen($this->productPhotoComment_title) == 0){
            $this->addError('productPhotoComment_title', $this->translator->_('Please enter the productPhotoComment title'));
        }else{
            $this->productPhotoComment->title = $this->productPhotoComment_title;
        }
        
        // productPhotoComment content
        $this->productPhotoComment_content = $this->cleanHtml($request->getPost('productPhotoComment_content'));
        if(strlen($this->productPhotoComment_content) == 0){
            $this->addError('productPhotoComment_content', $this->translator->_('Please enter the productPhotoComment content'));
        }else{
            $this->productPhotoComment->content = $this->productPhotoComment_content;
        }
        
        // productPhotoComment user
        $user = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->productPhotoComment->user = $user;
        
        // product id
        $this->product_id = $request->getPost('product_id');
        if(product_id <= 0){
            $this->addError('product_id', $this->translator->_('Product id must greater than 0'));
        }else{
            $product = $this->em->find('Champs\Entity\Product', $this->product_id);
            $this->productPhoto->product = $product;
        }
        
        // productPhoto id
        $this->productPhoto_id = $request->getPost('productPhoto_id');
        if($this->productPhoto_id <= 0){
            $this->addError('productPhoto_id', $this->translator->_('ProductPhoto id must greater than 0'));
        }else{
            $productPhoto = $this->em->find('Champs\Entity\ProductPhoto', $this->productPhoto_id);
            $this->productPhotoComment->productPhoto = $productPhoto;
        }
        
        //Profile
            //code here

        if (!$this->hasError()) {
            try {
                $this->_productPhotoCommentRepository->storeProductPhotoCommentEntity($this->productPhotoComment);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}