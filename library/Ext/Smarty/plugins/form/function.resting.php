<?php

function smarty_function_resting($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Early to bed and early to rise', $locale),
        $translator->_('Often night owls', $locale),
        $translator->_('Always earlybird', $locale),
        $translator->_('Occasionally lazy', $locale),
    );

    $options = array(
        'name' => 'resting',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}