<?php

/**
 * Create an location
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Location_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Location
     *
     * @var Champs\Entity\Repository\LocationRepository $_locationRepository
     */
    private $_locationRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Location
     *
     * @var Champs\Entity\Location $location
     */
    public $location = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_locationRepository = $this->em->getRepository('Champs\Entity\Location');

        // initialize location entity
        $this->location = new Champs\Entity\Location();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // location name
        $this->location_name = $this->sanitize($request->getPost('location_name'));

        if (strlen($this->location_name) == 0){
            $this->addError('location_name', $this->translator->_('Please enter the location name'));
        } else {
            $this->location->location_name = $this->location_name;
        }
            
        // country id
        $this->country_id = $request->getPost('country_id');
        
        //city id
        $this->city_id = $request->getPost('city_id');
        

        if (!$this->hasError()) {
            try {
                // get country entity
                $country = $this->em->find('Champs\Entity\Country', $this->country_id);
                $this->location->country = $country;
                
                // get city entity
                $city = $this->em->find('Champ\Entity\City', $this->city_id);
                $this->location->city = $city;
                
                $this->_locationRepository->storeLocationEntity($this->location, $this->_user_id);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}