<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initSessionPath() {
        $session = $this->getOption('session');

        Zend_Session::setOptions($session);
    }

    /**
     * Bootstrap application.ini config
     */
    protected function _initConfig() {
        $config = new Zend_Config($this->getOptions());

        Zend_Registry::set('config', $config);

        return $config;
    }

    /**
     * Bootstrap Smarty View
     * @return \Ext_View_Smarty
     */
    protected function _initView() {
        // initialize smarty view
        $view = new Ext_View_Smarty($this->getOption('smarty'));
        // setup viewRenderer with suffix and view
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewSuffix('tpl');
        $viewRenderer->setView($view);

        // store the view object to Zend_Registry
        Zend_Registry::set('smarty', $view);

        // ensure we have layout bootstrap
        $this->bootstrap('layout');
        // set the tpl suffix to layout also
        $layout = Zend_Layout::getMvcInstance();
        $layout->setViewSuffix('tpl');

        return $view;
    }

    /**
     * Sets default locale language
     */
    protected function _initLocale() {
        Zend_Locale::setDefault('zh_HK');
    }

    protected function _initRoutes() {
        // handle the user request
        $controller = Zend_Controller_Front::getInstance();

        // router object
        $router = $controller->getRouter();

        // dating browse
        $router->addRoute('dating_browse', new Zend_Controller_Router_Route(
                        'dating/browse/view/:view/page/:page',
                        array(
                            'controller' => 'dating',
                            'action' => 'browse'
                        )
        ));

        // dating online
        $router->addRoute('dating_online', new Zend_Controller_Router_Route(
                        'dating/online/view/:view/page/:page',
                        array(
                            'controller' => 'dating',
                            'action' => 'online'
                        )
        ));

        // dating user
        $router->addRoute('dating_user', new Zend_Controller_Router_Route(
                        'dating/user/:nickname',
                        array(
                            'controller' => 'dating',
                            'action' => 'user'
                        )
        ));

        // album
        $router->addRoute('album_album', new Zend_Controller_Router_Route(
                        'album/:id/photos',
                        array(
                            'controller' => 'album',
                            'action' => 'photos'
                        )
                )
        );
    }

    /**
     * Bootstrap Translatetion
     *
     * @return \Zend_Translate
     */
    protected function _initTranslate() {

        // initialize Zend_Translate
        $translate = new Zend_Translate(array(
                    'adapter' => 'array',
                    'content' => APPLICATION_PATH . '/languages/en_US.php',
                    'locale' => 'en_US',
                ));

        // setup language files
        // traditional chinese
        $translate->addTranslation(array(
            'content' => APPLICATION_PATH . '/languages/zh_HK.php',
            'locale' => 'zh_HK',
        ));

        // taiwan chinese
        $translate->addTranslation(array(
            'content' => APPLICATION_PATH . '/languages/zh_TW.php',
            'locale' => 'zh_TW',
        ));

        // simplified chinese
        $translate->addTranslation(array(
            'content' => APPLICATION_PATH . '/languages/zh_CN.php',
            'locale' => 'zh_CN',
        ));



        // add to zend_registry
        Zend_Registry::set('translate', $translate);

        return $translate;
    }

}

