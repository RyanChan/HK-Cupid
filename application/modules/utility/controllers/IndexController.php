<?php

use Champs\Controller\MasterController;

class Utility_IndexController extends MasterController {

    public function init() {
        parent::init();

        Zend_Layout::getMvcInstance()->disableLayout();
    }

    public function indexAction() {

    }

    public function imageAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $module = (string) $request->getParam('m');
        $id = (int) $request->getParam('id');
        $w = (int) $request->getParam('w');
        $h = (int) $request->getParam('h');
        $hash = $request->getParam('hash');

        $realHash = Champs\Utility\Image::GetImageHash($module, $id, $w, $h);

        $this->_helper->viewRenderer->setNoRender();

        $image = new \Champs\Utility\Image('kimchan', $module, $id);
        if ($hash != $realHash){
            $response->setHttpResponseCode(404);
            return;
        }

        try{
            $fullpath = $image->createThumbnail($w, $h);
        }  catch (Exception $e){
            $fullpath = $image->getImagePath();
        }

        $info = getimagesize($fullpath);

        $response->setHeader('content-type', $info['mime']);
        $response->setHeader('content-length', filesize($fullpath));
        echo file_get_contents($fullpath);
    }

}