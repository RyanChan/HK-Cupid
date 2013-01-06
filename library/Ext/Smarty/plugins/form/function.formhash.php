<?php

/**
 * Description of function
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
function smarty_function_formhash($params, Smarty_Internal_Template $template) {
    $hash = isset($params['hash']) ? $params['hash'] : null;

    $hashField = sprintf('<input type="hidden" name="hash" value="%s" />', $hash);

    return $hashField;
}