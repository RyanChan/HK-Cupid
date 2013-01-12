<?php

class Champs_Form_Payment_Create extends Champs_FormProcessor {
    
    /**
     * @var Champs\Entity\Repository\PaymentRepository $_paymentRepository
     */
    private $_paymentRepository = null;
    
    /**
     * @var Champs\Entity\Payment $payment
     */
    public $payment = null;
    
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
        
        $this->_paymentRepository = $this->em->getRepository('Champs\Entity\Payment');
        $this->payment = new Champs\Entity\Payment();
    }
    
    /**
     * 
     * @param Zend/Controller/Request/Abstract $request
     * @return boolean
     */
    public function process(\Zend_Controller_Request_Abstract $request) {
        // payment type
        $this->payment_type = $this->sanitize($request->getPost('payment_type'));
        $this->payment->type = $this->payment_type;
        
        // payment content
        $this->payment_content = $this->cleanHtml($request->getPost('payment_content'));
        
        if (strlen($this->payment_content) == 0) {
            $this->addError('payment_content', $this->translator->_('Please enter content'));
        } else {
            $this->payment->content = $this->payment_content;
        }
        
        if (!$this->hasError()) {
            try {
                $this->_paymentRepository->storePaymentEntity($this->payment);
            } catch(Exception $e) {
                $this->addError('error', $e->getMessage());
            }
        }
        
        return !$this->hasError();
    }
}