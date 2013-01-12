<?php

class Champs_Form_Category_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\CategoryRepository $_categoryRepository
     */
    private $_categoryRepository = null;
    
    /**
     * @var Champs\Entity\Category $category
     */
    public $category = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_categoryRepository = $this->em->getRepository('Champs\Entity\Category');
        $this->category = new Champs\Entity\Category();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        
        // category name
        $this->category_name = $this->sanitize($request->getPost('category_name'));
        if(strlen($this->category_name) == 0){
            $this->addError('category_name', $this->translator->_('Please enter category name'));
        } else {
            $this->category->category_name = $this->category_name;
        }
        
        // category enabled
        $this->category_enabled = $request->getPost('category_enabled');
        $this->category->enabled $this->category_enabled;
        
        // category ranking
        $this->category_ranking = $request->getPost('category_ranking');
        if($this->category_ranking < 0){
            $this->addError('category_ranking', $this->translator->_('Ranking must greater than -1'));
        } else {
            $this->category->ranking = $this->category_ranking;
        }
        
        
        if (!$this->hasError()) {
            try {
                $this->_categoryRepository->storeCategoryEntity($this->category);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}