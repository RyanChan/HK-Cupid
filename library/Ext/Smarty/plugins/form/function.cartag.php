<?php

function smarty_function_cartag($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('I don\'t have a car'),
        $translator->_('I have a car'),
        $translator->_('I have a car and giving by company'),
        $translator->_('I have more than one cars')
    );

    $options = array(
        'name' => 'cartag',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}