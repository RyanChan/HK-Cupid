<?php

function smarty_function_breadcrumb($params, Smarty_Internal_Template $template) {
    $defaultParams = array(
        'trail' => array(),
        'separator' => ' / ',
        'truncate' => 40
    );

    foreach ($defaultParams as $k => $v) {
        if (!isset($params[$k]))
            $params[$k] = $v;
    }

    if ($params['truncate'] > 0)
        require_once $template->smarty->_get_plugin_filepath('modifier', 'truncate');

    $links = array();
    $numSteps = count($params['trail']);
    for ($i = 0; $i < $numSteps; $i++) {
        $step = $params['trail'][$i];

        if ($params['truncate'] > 0)
            $step['title'] = smarty_modifier_truncate($step['title'], $params['truncate']);

        if (strlen($step['link']) > 0 && $i < $numSteps - 1) {
            $links[] = sprintf(
                    '<li><a href="%s" title="%s">%s</a> <span class="divider">%s</span></li>',
                    htmlspecialchars($step['link']),
                    htmlspecialchars($step['title']),
                    htmlspecialchars($step['title']),
                    htmlspecialchars($params['separator'])
            );
        } else {
            $links[] = sprintf('<li class="active">%s</li>', htmlspecialchars($step['title']));
        }
    }

    return join('', $links);
}