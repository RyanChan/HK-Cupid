<?php

function smarty_function_romance($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Always', $locale),
        $translator->_('Sometimes', $locale),
        $translator->_('Depends on situation', $locale),
        $translator->_('Never', $locale),
        $translator->_('Don\'t like', $locale)
    );

    $options = array(
        'name' => 'romance',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}