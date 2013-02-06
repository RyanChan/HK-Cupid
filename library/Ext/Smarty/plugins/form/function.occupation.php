<?php

function smarty_function_occupation($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Information Technology', $locale),
        $translator->_('Human Resource', $locale),
        $translator->_('Government', $locale),
        $translator->_('Construction', $locale),
        $translator->_('Accounting', $locale),
        $translator->_('Traveling', $locale),
        $translator->_('Law', $locale),
        $translator->_('Medication', $locale),
        $translator->_('Education', $locale),
        $translator->_('Others', $locale)
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    $parameters = array(
        'options' => $data,
        'name' => 'occupation',
        'selected' => $default
    );

    return smarty_function_html_options($parameters, $template);
}