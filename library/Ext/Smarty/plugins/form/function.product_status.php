<?php

/**
 * Product's status selection
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
function smarty_function_product_status ($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('On Sale'),
        $translator->_('Out Of Stock'),
        $translator->_('Remove From Sale'),
    );


    $options = array(
        'name' => 'product_status',
        'selected' => $default,
        'options' => $data,
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}