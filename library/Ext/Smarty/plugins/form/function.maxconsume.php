<?php

function smarty_function_maxconsume($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Food', $locale),
        $translator->_('Clothing', $locale),
        $translator->_('Entertainment', $locale),
        $translator->_('Traveling', $locale),
        $translator->_('Dating', $locale),
        $translator->_('Culture', $locale),
        $translator->_('Education', $locale),
        $translator->_('Others', $locale)
    );

    $options = array(
        'name' => 'maxconsume',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}