<?php

function smarty_function_maxconsume($params, Smarty_Internal_Template $template) {
    $default = isset($params['default']) ? $params['default'] : null;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Food'),
        $translator->_('Clothing'),
        $translator->_('Entertainment'),
        $translator->_('Traveling'),
        $translator->_('Dating'),
        $translator->_('Culture'),
        $translator->_('Education'),
        $translator->_('Others')
    );

    $options = array(
        'name' => 'maxconsume',
        'selected' => $default,
        'options' => $data
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}