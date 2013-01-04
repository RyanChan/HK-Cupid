<?php

class UtilityController extends Champs_Controller_MasterController {

    public function init() {
        parent::init();

        Zend_Layout::getMvcInstance()->disableLayout();
    }

    public function indexAction() {
        /*
        if ($this->getRequest()->isPost()) {
            try {
                $file = $_FILES['image'];
                echo $file['tmp_name'];
                $album = $this->em->find('Champs\Entity\Album', 6);
                $photoEntity = new Champs\Entity\Photo();
                $photoEntity->album = $album;
                $photoEntity->user = $album->user;
                $photoEntity->description = "Testing";
                $photoEntity->uploadFile($file['tmp_name']);
                $photoEntity->filepath = basename($file['name']);

                $this->em->persist($photoEntity);
                $this->em->flush();

                echo file_get_contents ($photoEntity->createThumbnail(100, 100));
            } catch (Exception $e) {
                $this->view->e = $e->getMessage();

            }
        }
        */
    }

    public function imageAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $id = (int) $request->getParam('id');
        $w = (int) $request->getParam('w');
        $h = (int) $request->getParam('h');
        $hash = $request->getParam('hash');

        $realHash = Champs\Entity\Photo::GetImageHash($id, $w, $h);

        $this->setNoRender();

        $image = $this->em->find('Champs\Entity\Photo', $id);
        if ($hash != $realHash || $image === null) {
            $response->setHttpResponseCode(404);
            return;
        }

        try {
            $fullpath = $image->createThumbnail($w, $h);
        } catch (Exception $e) {
            $fullpath = $image->getImagePath();
        }

        $info = getimagesize($fullpath);

        $response->setHeader('content-type', $info['mime']);
        $response->setHeader('content-length', filesize($fullpath));
        echo file_get_contents($fullpath);
    }

}