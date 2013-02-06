<?php

function smarty_function_housetag ($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Live alone', $locale),
        $translator->_('Shared with roommates', $locale),
        $translator->_('Shared with family', $locale),
        $translator->_('Cosmopolitan', $locale)
    );

    $options = array(
        'name' => 'house_tag',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}