<?php

function smarty_function_bodytype($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Standard', $locale),
        $translator->_('Symmetry', $locale),
        $translator->_('Plump', $locale),
        $translator->_('Sexy', $locale),
        $translator->_('Slim', $locale),
        $translator->_('Tall', $locale),
        $translator->_('Small', $locale),
        $translator->_('Thin', $locale),
        $translator->_('Fat', $locale),
        $translator->_('Robust', $locale)
    );

    $options = array(
        'options' => $data,
        'selected' => $default,
        'name' => 'bodytype'
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}