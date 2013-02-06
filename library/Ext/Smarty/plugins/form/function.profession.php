<?php

function smarty_function_profession($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('CEO', $locale),
        $translator->_('Accountant', $locale),
        $translator->_('Lawyer', $locale),
        $translator->_('Doctor', $locale),
        $translator->_('Pilot', $locale),
        $translator->_('Coach', $locale),
        $translator->_('Designer', $locale),
        $translator->_('Engineer', $locale),
        $translator->_('Teacher', $locale),
        $translator->_('Cop', $locale),
        $translator->_('Model', $locale),
        $translator->_('Others', $locale)
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    $parameters = array(
        'options' => $data,
        'name' => 'profession',
        'selected' => $default
    );

    return smarty_function_html_options($parameters, $template);
}