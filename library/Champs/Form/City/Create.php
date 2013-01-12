<?php

class Champs_Form_City_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\CityRepository $_cityRepository
     */
    private $_cityRepository = null;
    
    /**
     * @var Champs\Entity\City $city
     */
    public $city = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_cityRepository = $this->em->getRepository('Champs\Entity\City');
        $this->city = new Champs\Entity\City();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // country id
        $this->country_id = $request->getPost('country_id');
        if($this->country_id < 0){
            $this->addError('country_id', $this->translator->_('Country id must greater than 0'));
        }
        
        // city name
        $this->city_name = $this->sanitize($request->getPost('city_name'));
        if(strlen($this->city_name) == 0){
            $this->addError('city_name', $this->translator->_('Please enter city name'));
        } else {
            $this->city->city_name = $this->city_name;
        }
        
        if (!$this->hasError()) {
            try {
                $country = $this->em->find('Champs\Entity\Country', $this->country_id);
                $this->city->country = $country;
                $this->_cityRepository->storeCityEntity($this->city);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}