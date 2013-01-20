<?php

/**
 * Product's searchable method selection
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
function smarty_function_product_searchable($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Yes'),
        $translator->_('No'),
    );

    $options = array(
        'name' => 'product_searchable',
        'selected' => $default,
        'options' => $data,
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}