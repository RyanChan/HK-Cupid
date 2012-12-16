<?php

function smarty_function_resting($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Early to bed and early to rise is the loaw'),
        $translator->_('Often night owls'),
        $translator->_('Always earlybird'),
        $translator->_('Occasionally lazy'),
        $translator->_('No law')
    );

    $options = array(
        'name' => 'resting',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}