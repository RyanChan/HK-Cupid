<?php

function smarty_function_nbsp ($params, Smarty_Internal_Template $template) {
    $nbsp = isset($params['nbsp']) ? $params['nbsp'] : 0;

    if ($nbsp <= 0)
        return null;

    $codes = '';

    for ($i = 0; $i < $nbsp; $i++) {
        $codes .= '&nbsp;';
    }

    return $codes;
}