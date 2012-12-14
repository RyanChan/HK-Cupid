<?php

function smarty_function_occupation($params, Smarty_Internal_Template $template){
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Information Technology'),
        $translator->_('Human Resource'),
        $translator->_('Government'),
        $translator->_('Construction'),
        $translator->_('Accounting'),
        $translator->_('Traveling'),
        $translator->_('Law'),
        $translator->_('Medication'),
        $translator->_('Education'),
        $translator->_('Others')
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    $parameters = array(
        'options' => $data,
        'name' => 'occupation',
        'selected' => $default
    );

    return smarty_function_html_options($parameters, $template);
}