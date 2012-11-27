<?php

/**
 * Champs Mail
 *
 * Customize mail agent
 */
class Champs_Mail {

    /**
     * Smarty object
     *
     * @var Ext_View_Smarty $_smarty
     */
    private $_smarty = null;

    /**
     * path/prefix of the path of the template
     *
     * @var string $_path
     */
    private $_path = null;

    /**
     * mail's subject
     *
     * @var string $subject
     */
    protected $subject = null;

    /**
     * mail's body with html format
     *
     * @var string $bodyHTML
     */
    protected $bodyHTML = null;

    /**
     * Zend_Mail object
     *
     * @var Zend_Mail $mail
     */
    protected $mail = null;

    /**
     * from array that contains address & name
     *
     * @var array $from
     */
    protected $from = array();

    /**
     * to array that contains address & name
     *
     * @var array $to
     */
    protected $to = array();

    /**
     * object that will be used in the template
     *
     * @var mixed $object
     */
    public $object = null;

    /**
     * Initialize method
     */
    public function __construct() {
        // get the smarty object
        $this->_smarty = Zend_Registry::get('smarty');
        // initialize Zend_Mail object and set the charset to utf-8
        $this->mail = new Zend_Mail(Zend_Registry::get('config')->global->charset);
        // initialize the from address & name of the mail
        $this->from = array(
            'address' => Zend_Registry::get('config')->global->mail->default->from->address,
            'name' => Zend_Registry::get('config')->global->mail->default->from->name
        );
        // set the default path/prefix
        $this->_path = 'email/';
    }

    /**
     * Set the path of template
     *
     * @param string $path
     */
    public function setPath($path) {
        $this->_path = $path;
        return $this;
    }

    /**
     * Set to array
     *
     * @param type $address
     * @param type $name
     */
    public function setTo($address, $name) {
        $this->to = array('address' => $address, 'name' => $name);
        return $this;
    }

    /**
     * Set the body with html format
     *
     * @param string $html
     */
    public function setBodyHTML($html) {
//        $this->bodyHTML = $this->_smarty->render($this->_path . $html);
        $this->mail->setBodyHtml($this->_smarty->render($this->_path . $html), Zend_Registry::get('config')->global->charset);
        return $this;
    }

    /**
     * Set the subject of the mail
     *
     * @param type $subject
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Sets the object that will be used in the template
     *
     * @param array $object
     */
    public function setObject($object) {
        if (is_array($object)) {
            foreach ($object as $k => $v) {
                $this->_smarty->assign($k, $v);
            }
        }
        return $this;
    }

    /**
     * Send the mail
     *
     * @return boolean
     */
    public function send() {
        $this->mail->setSubject($this->subject);
        $this->mail->setFrom($this->from['address'], $this->from['name']);
        $this->mail->addTo($this->to['address'], $this->to['name']);
        return $this->mail->send();
    }

    /**
     * Static method
     *
     * send mail with options
     *
     * @param array $options
     */
    public static function sendMail(array $options) {
        $default = array(
            'from' => array(
                'address' => Zend_Registry::get('config')->global->mail->default->from->address,
                'name' => Zend_Registry::get('config')->global->mail->default->from->name,
            ),
            'to' => array(
                'address' => '',
                'name' => '',
            ),
            'template' => '',
            'path' => 'email/',
            'subject' => '',
        );

        foreach ($default as $k => $v) {
            $options = array_key_exists($k, $options) ? $options[$k] : $v;
        }

        if (!isset($options['to']['address']) || !isset($options['to']['name']))
            throw new Exception('Mail\'s To address or name have not been set.');
        else if (!isset($options['to']['address']) && !isset($options['to']['name']))
            throw new Exception('Mail\'s To address and name have not been set.');

        $mail = new $this();

        $mail->setSubject($options['subject']);
        $mail->setPath($options['path']);
        $mail->setTo($options['to']['address'], $options['to']['name']);
        $mail->setBodyHTML($options['template']);
        $result = $mail->send();
        if (!$result)
            throw new Exception('Mail have not been sent. Please try again later.');
        else
            return true;
    }

}