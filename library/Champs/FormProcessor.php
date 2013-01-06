<?php

abstract class Champs_FormProcessor {

    /**
     *
     * @var Doctrine\ORM\EntityManager $em
     */
    protected $em = null;

    /**
     *
     * @var array $_errors
     */
    protected $_errors = array();

    /**
     *
     * @var array $_vals
     */
    protected $_vals = array();

    /**
     *
     * @var mixed $_sanitizeChain
     */
    private $_sanitizeChain = null;

    /**
     *
     * @var array $tags
     */
    static $tags = array(
        'a' => array('href', 'target', 'name'),
        'img' => array('src', 'alt'),
        'b' => array(),
        'strong' => array(),
        'em' => array(),
        'i' => array(),
        'ul' => array(),
        'li' => array(),
        'ol' => array(),
        'p' => array(),
        'br' => array()
    );

    /**
     *
     * @var Zend_Translate $translator
     */
    protected $translator = null;

    public function __construct() {
        $this->em = Zend_Registry::get('doctrine')->getEntityManager();
        $this->translator = Zend_Registry::get('translate');
    }

    abstract function process(Zend_Controller_Request_Abstract $request);

    public function sanitize($value) {
        if (!$this->_sanitizeChain instanceof Zend_Filter) {
            $this->_sanitizeChain = new Zend_Filter();
            $this->_sanitizeChain->addFilter(new Zend_Filter_StringTrim())
                    ->addFilter(new Zend_Filter_StripTags());
        }

        // filter out any line feeds / carriage returns
        $ret = preg_replace('/[\r\n]+/', ' ', $value);

        // filter using the above chain
        return $this->_sanitizeChain->filter($ret);
    }

    public function addError($key, $val) {
        if (array_key_exists($key, $this->_errors)) {
            if (!is_array($this->_errors[$key]))
                $this->_errors[$key] = array($this->_errors[$key]);

            $this->_errors[$key][] = $val;
        }
        else
            $this->_errors[$key] = $val;
    }

    public function getError($key) {
        if ($this->hasError($key))
            return $this->_errors[$key];

        return null;
    }

    public function getErrors() {
        return $this->_errors;
    }

    public function hasError($key = null) {
        if (strlen($key) == 0)
            return count($this->_errors) > 0;

        return array_key_exists($key, $this->_errors);
    }

    public function __set($name, $value) {
        $this->_vals[$name] = $value;
    }

    public function __get($name) {
        return array_key_exists($name, $this->_vals) ? $this->_vals[$name] : null;
    }

    public function cleanHtml($html) {
        $chain = new Zend_Filter();
        $chain->addFilter(new Zend_Filter_StripTags(self::$tags));
        $chain->addFilter(new Zend_Filter_StringTrim());

        $html = $chain->filter($html);

        $tmp = $html;
        while (1) {
            // Try and replace an occurrence of javascript:
            $html = preg_replace('/(<[^>]*)javascript:([^>]*>)/i', '$1$2', $html);

            // If nothing changed this iteration then break the loop
            if ($html == $tmp)
                break;

            $tmp = $html;
        }

        return $html;
    }

}