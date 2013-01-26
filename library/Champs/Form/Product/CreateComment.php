<?php

/**
 * Create an productComment
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_ProductComment_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of ProductComment
     *
     * @var Champs\Entity\Repository\ProductCommentRepository $_productCommentRepository
     */
    private $_productCommentRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of ProductComment
     *
     * @var Champs\Entity\ProductComment $productComment
     */
    public $productComment = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_productCommentRepository = $this->em->getRepository('Champs\Entity\ProductComment');

        // initialize productComment entity
        $this->productComment = new Champs\Entity\ProductComment();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // productComment title
        $this->productComment_title = $this->sanitize($request->getPost('productComment_title'));
        if(strlen($this->productComment_title) == 0){
            $this->addError('productComment_title', $this->translator->_('Please enter the productComment title'));
        }else{
            $this->productComment->title = $this->productComment_title;
        }
        
        // productComment content
        $this->productComment_content = $this->cleanHtml($request->getPost('productComment_content'));
        if(strlen($this->productComment_content) == 0){
            $this->addError('productComment_content', $this->translator->_('Please enter the productComment content'));
        }else{
            $this->productComment->content = $this->productComment_content;
        }
        
        // productComment user
        $user = $this->em->find('Champs\Entity\User', $this->_user_id);
        $this->productComment->user = $user;
        
        // product id
        $this->product_id = $request->getPost('product_id');
        if($this->product_id <= 0){
            $this->addError('product_id', $this->translator->_('Product id must greater than 0'));
        }else{
            $product = $this->em->find('Champs\Entity\Product', $this->product_id);
            $this->productComment->product = $product;
        }
        
        // edited
        $this->productComment->setProfileWithKeyAndValue('edited', false);
        
        // hidden
        $this->productComment->setProfileWithKeyAndValue('hidden', false);

        if (!$this->hasError()) {
            try {
                $this->_productCommentRepository->storeProductCommentEntity($this->productComment);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}