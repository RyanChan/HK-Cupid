<?php

/**
 * Description of MessageController
 *
 * @author RyanChan
 */
class MessageController extends Champs_Controller_MasterController {

    /**
     *
     * @var Champs\Entity\Repository\MessageRepository $messageRepository
     */
    protected $messageRepsoitory = null;

    public function init() {
        parent::init();

        $this->messageRepsoitory = $this->em->getRepository('Champs\Entity\Message');
    }

    public function composeAction() {
        $request = $this->getRequest();

        if (!$request->isPost() && !$this->checkHash($request->getPost('hash'))) {
            $this->throwPageNotFound();
        }

        $form = new Champs_Form_Message_Compose();

        if ($form->process($request)) {
            $this->_redirect($request->getPost('redirect'));
        } else {
//            $this->_redirect($request->getPost('redirect'));
            $this->view->error = $form->getErrors();
        }

        $this->view->form = $form;

        $this->initHash();
    }

    public function deleteAction() {
        $this->setNoRender();

        $request = $this->getRequest();

        if (!$request->isPost() && !$this->checkHasha($request->getPost('hash'))) {
            $this->throwPageNotFound();
        }

        $message = $this->messageRepsoitory->find($request->getPost('id'));

        if (!$message) {
            $this->throwPageNotFound();
        }

        if ($message->user->id != $this->identity->user_id) {
            $this->throwPageNotFound();
        }

        $this->em->remove($message);
        $this->em->flush();

        $this->_redirect($request->getPost('redirect'));
    }

    public function messagesAction() {
        $messages = $this->messageRepsoitory->getAllMessagesForUser();

        $this->view->messages = $messages;

        $this->initHash();
    }

}