<?php

class Champs_Form_Store_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\StoreRepository $_storeRepository
     */
    private $_storeRepository = null;
    
    /**
     * @var Champs\Entity\Store $store
     */
    public $store = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_storeRepository = $this->em->getRepository('Champs\Entity\Store');
        $this->store = new Champs\Entity\Store();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // store storename
        $this->store_storename = $this->sanitize($request->getPost('store_storename'));
        if(strlen($this->store_storename) == 0){
            $this->addError('store_storename', $this->translator->_('Please enter store storename'));
        } else {
            $this->store->storename = $this->store_storename;
        }
        
        //category id
        $this->category_id = $request->getPost('category_id');
        if($this->category_id <= 0){
            $this->addError('category_id', $this->translator->_('Category id must greater than 0'));
        }else{
            $category = $this->em->find('Champs\Entity\Category', $this->category_id);
            $this->store->category = $category;
        }
        
        //user id
        $this->user_id = $request->getPost('user_id');
        if($this->user_id <= 0){
            $this->addError('user_id', $this->translator->_('User id must greater than 0'));
        }else{
            $user = $this->em->find('Champs\Entity\User', $this->user_id);
            $this->store->owner = $user;
        }
        
        if (!$this->hasError()) {
            try {
                $this->_storeRepository->storeStoreEntity($this->store);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}