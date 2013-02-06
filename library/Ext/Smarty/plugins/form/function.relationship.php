<?php

function smarty_function_relationship($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Single', $locale),
        $translator->_('In Relationship', $locale),
        $translator->_('Married', $locale),
        $translator->_('Complicated', $locale)
    );

    $options = array(
        'name' => 'relationship',
        'options' => $data,
        'selected' => $default
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}