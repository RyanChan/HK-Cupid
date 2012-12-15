<?php

function smarty_function_bodytype($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Standard'),
        $translator->_('Symmetry'),
        $translator->_('Plump'),
        $translator->_('Sexy'),
        $translator->_('Slim'),
        $translator->_('Scouring'),
        $translator->_('Tall'),
        $translator->_('Small'),
        $translator->_('Thin'),
        $translator->_('Fat'),
        $translator->_('Robust')
    );

    $options = array(
        'options' => $data,
        'selected' => $default,
        'name' => 'bodytype'
    );
    
    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}