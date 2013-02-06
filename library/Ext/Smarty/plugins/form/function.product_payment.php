<?php

/**
 * Product's payment method selection
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
function smarty_function_product_payment ($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('VISA', $locale),
        $translator->_('Master Card', $locale),
        $translator->_('Paypal', $locale)
    );

    $options = array(
        'name' => 'product_payment',
        'selected' => $default,
        'options' => $data,
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}