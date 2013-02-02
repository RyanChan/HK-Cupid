<?php

function smarty_function_locale ($params, Smarty_Internal_Template $template) {
    $default = (int) isset($params['default']) ? $params['default'] : 0;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('English'),
        $translator->_('Traditional Chinese'),
        $translator->_('Simplified Chinese')
    );

    $options = array(
        'name' => 'locale',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}