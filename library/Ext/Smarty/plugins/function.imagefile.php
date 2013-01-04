<?php

/**
 * Get the image file
 *
 * @author RyanChan <ryanchan.tc@gmail.com>
 */
function smarty_function_imagefile($params, Smarty_Internal_Template $template) {
    $id = isset($params['id']) ? $params['id'] : 0;
    $w = isset($params['w']) ? $params['w'] : 0;
    $h = isset($params['h']) ? $params['h'] : 0;

    require_once $template->smarty->_get_plugin_filepath('function', 'geturl');

    $hash = Champs\Entity\Photo::GetImageHash($id, $w, $h);

    $options = array(
        'controller' => 'utility',
        'action' => 'image'
    );

    return sprintf('%s?id=%d&w=%d&h=%d&hash=%s',
                    smarty_function_geturl($options, $template),
                    $id,
                    $w,
                    $h,
                    $hash
            );
}