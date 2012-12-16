<?php

function smarty_function_smoking($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Do not smoke, very disgusted smoking'),
        $translator->_('Do not smoke, but not objectionable smoking'),
        $translator->_('Social occasionally smoke'),
        $translator->_('Smoke a few times a week'),
        $translator->_('Daily smoke'),
        $translator->_('Addicted')
    );

    $options = array(
        'name' => 'smoking',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}