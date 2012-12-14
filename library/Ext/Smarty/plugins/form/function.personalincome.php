<?php

/**
 *
 * @param type $params
 * @param Smarty_Internal_Template $template
 */
function smarty_function_personalincome ($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('$5000 - $10000'),
        $translator->_('$10000 - $20000'),
        $translator->_('$20000 - $30000'),
        $translator->_('$30000 - $40000'),
        $translator->_('$40000 - $50000'),

    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    $parameters = array(
        'selected' => $default,
        'name' => 'personalincome',
        'options' => $data
    );

    return smarty_function_html_options($parameters, $template);
}