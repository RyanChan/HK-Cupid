<?php

function smarty_function_smoking($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Do not smoke, very disgusted smoking', $locale),
        $translator->_('Do not smoke, but not objectionable smoking', $locale),
        $translator->_('Social occasionally smoke', $locale),
        $translator->_('Smoke a few times a week', $locale),
        $translator->_('Daily smoke', $locale),
        $translator->_('Addicted', $locale)
    );

    $options = array(
        'name' => 'smoking',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}