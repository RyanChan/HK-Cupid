<?php

function smarty_function_interested_in ($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : 0;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Women'),
        $translator->_('Male'),
        $translator->_('Both')
    );

    $options = array(
        'name' => 'interested_in',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}