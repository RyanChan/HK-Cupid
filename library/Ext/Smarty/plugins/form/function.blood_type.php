<?php

function smarty_function_blood_type ($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('A'),
        $translator->_('B'),
        $translator->_('O'),
        $translator->_('AB')
    );

    $options = array(
        'name' => 'blood_type',
        'selected' => $default,
        'options' => $data,
        'class' => 'span4'
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}