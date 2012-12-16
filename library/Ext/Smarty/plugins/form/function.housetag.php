<?php

function smarty_function_housetag ($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Live alone'),
        $translator->_('Shared with roommates'),
        $translator->_('Shared with family'),
        $translator->_('Cosmopolitan')
    );

    $options = array(
        'name' => 'house_tag',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}