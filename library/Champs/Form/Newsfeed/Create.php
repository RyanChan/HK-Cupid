<?php

/**
 * Create an newsfeed
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
class Champs_Form_Newsfeed_Create extends Champs_FormProcessor {

    /**
     * Enttiy Repository of Newsfeed
     *
     * @var Champs\Entity\Repository\NewsfeedRepository $_newsfeedRepository
     */
    private $_newsfeedRepository = null;

    /**
     * Identity of current user
     *
     * @var integer $_user_id
     */
    private $_user_id = null;

    /**
     * Entity of Newsfeed
     *
     * @var Champs\Entity\Newsfeed $newsfeed
     */
    public $newsfeed = null;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // get the repository from doctrine entity manager
        $this->_newsfeedRepository = $this->em->getRepository('Champs\Entity\Newsfeed');

        // initialize newsfeed entity
        $this->newsfeed = new Champs\Entity\Newsfeed();

        // get the user's id
        $this->_user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
    }

    /**
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function process(\Zend_Controller_Request_Abstract $request) {      
        // newsfeed content
        $this->newsfeed_content = $this->cleanHtml($request->getPost('newsfeed_content'));
        if(strlen($this->newsfeed_content) == 0){
            $this->addError('newsfeed_content', $this->translator->_('Please enter newsfeed content'));
        } else {
            $this->newsfeed->content = $this->newsfeed_content;
        }
        
        // category id
        $this->category_id = $request->getPost('category_id');
        if($this->category_id <= 0){
            $this->addError('category_id', $this->translator->_('Category id must greater than 0'));
        }else{
            $category = $this->em->find('Champs\Entity\Category', $this->category_id);
            $this->newsfeed->category = $category;
        }
        
        //Proile
            //code here

        if (!$this->hasError()) {
            try {
                $this->_newsfeedRepository->storeNewsFeedEntity($this->newsfeed);
            } catch (Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }

        return !$this->hasError();
    }

}