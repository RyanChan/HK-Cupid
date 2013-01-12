<?php

class Champs_Form_Country_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\CountryRepository $_countryRepository
     */
    private $_countryRepository = null;
    
    /**
     * @var Champs\Entity\Country $country
     */
    public $country = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_countryRepository = $this->em->getRepository('Champs\Entity\Country');
        $this->country = new Champs\Entity\Country();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        
        // country name
        $this->country_name = $this->sanitize($request->getPost('country_name'));
        if(strlen($this->country_name) == 0){
            $this->addError('country_name', $this->translator->_('Please enter country name'));
        } else {
            $this->country->country_name = $this->country_name;
        }
        
        if (!$this->hasError()) {
            try {
                $this->_countryRepository->storeCountryEntity($this->country);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}