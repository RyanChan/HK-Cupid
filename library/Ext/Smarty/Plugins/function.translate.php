<?php

function smarty_function_translate($params, Smarty_Internal_Template $template){
    $name = (string) $params['name'];
    $auto = isset($params['auto']) ? $params['auto'] : null;
    $locale = null;

    if (!$auto){
        $locale = key(Zend_Locale::getDefault());
    }

    if (strlen($name) > 0){
        $newName = Zend_Registry::get('translate')->_($name, $locale);

        if ($name == $newName){
            return $name;
        }  else {
            return $newName;
        }
    }

    return $name;
}