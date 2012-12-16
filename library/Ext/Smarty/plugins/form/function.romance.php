<?php

function smarty_function_romance($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Always'),
        $translator->_('Sometimes'),
        $translator->_('Depends on situation'),
        $translator->_('Never'),
        $translator->_('Don\'t like')
    );

    $options = array(
        'name' => 'romance',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}