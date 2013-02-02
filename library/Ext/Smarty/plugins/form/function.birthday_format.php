<?php

function smarty_function_birthday_format ($params, Smarty_Internal_Template $template) {
    $default = (int) isset($params['default']) ? $params['default'] : 0;

    $translator = Zend_Registry::get('translate');

    $data = array(
        $translator->_('Show only month & day'),
        $translator->_('Show full birthday')
    );

    $options = array(
        'name' => 'birthday_format',
        'selected' => $default,
        'options' => $data,
        'class' => 'span6'
    );

    require_once $template->smarty->_get_plugin_filepath('function', 'html_options');

    return smarty_function_html_options($options, $template);
}