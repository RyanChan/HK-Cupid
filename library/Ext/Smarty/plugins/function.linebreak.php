<?php

function smarty_function_linebreak($params, Smarty_Internal_Template $template) {
    $br = '<br />';

    $repeat = (int) isset($params['repeat']) ? $params['repeat'] : 0;

    for ($i = 0; $i < $repeat; $i++) {
        $br .= '<br />';
    }

    return $br;
}