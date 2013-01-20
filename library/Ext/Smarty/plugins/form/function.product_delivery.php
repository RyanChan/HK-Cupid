<?php

/**
 * Product's delivery method selection
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
function smarty_function_product_delivery($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Post'),
        $translator->_('DHL'),
        $translator->_('Speed Post'),
        $translator->_('FedEx'),
    );

    $options = array(
        'name' => 'product_delivery',
        'selected' => $default,
        'options' => $data,
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}