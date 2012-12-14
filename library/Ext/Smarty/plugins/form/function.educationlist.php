<?php

/**
 * Account form - education list
 *
 * @param mixed $params
 * @param Smarty_Internal_Template $template
 */
function smarty_function_educationlist($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $list = array(
        $translator->_('Primary School'),
        $translator->_('Secondary School'),
        $translator->_('High School'),
        $translator->_('Bachelor'),
        $translator->_('Master'),
        $translator->_('Doctor')
    );

    $options = array(
        'name' => 'education',
        'options' => $list,
        'selected' => $default
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}