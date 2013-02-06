<?php

function smarty_function_drinking($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Not drinking', $locale),
        $translator->_('Social need to drinking', $locale),
        $translator->_('In the mood to drinking', $locale),
        $translator->_('Can\'t live without wine', $locale)
    );

    $options = array(
        'name' => 'drinking',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}