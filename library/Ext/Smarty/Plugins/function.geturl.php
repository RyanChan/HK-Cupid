<?php

function smarty_function_geturl($params, Smarty_Internal_Template $template) {
    $action = isset($params['action']) ? $params['action'] : null;
    $controller = isset($params['controller']) ? $params['controller'] : null;
//    $module = isset($params['module']) ? $params['module'] : null;
    $route = isset($params['route']) ? $params['route'] : null;

    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('url');

    if (strlen($route) > 0) {
        unset($params['route']);
        $url = $helper->url(params, $route);
    } else {
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

        $url = $baseUrl;
        $url .= $helper->simple($action, $controller);
    }

    return $url;
}