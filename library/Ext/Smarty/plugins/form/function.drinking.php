<?php

function smarty_function_drinking($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Not drinking'),
        $translator->_('Social need to drinking'),
        $translator->_('In the mood to drinking'),
        $translator->_('Can\'t live without wine')
    );

    $options = array(
        'name' => 'drinking',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}