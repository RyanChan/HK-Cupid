<?php

function smarty_function_profession($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('CEO'),
        $translator->_('Accountant'),
        $translator->_('Lawyer'),
        $translator->_('Doctor'),
        $translator->_('Pilot'),
        $translator->_('Coach'),
        $translator->_('Designer'),
        $translator->_('Engineer'),
        $translator->_('Teacher'),
        $translator->_('Cop'),
        $translator->_('Model'),
        $translator->_('Others')
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    $parameters = array(
        'options' => $data,
        'name' => 'profession',
        'selected' => $default
    );

    return smarty_function_html_options($parameters, $template);
}