<?php

namespace App\Controller;

class MessageController extends BaseController {

    /**
     * get all messages
     * @param none
     * @return array[MessageEntity]
     */
    public function get()
    {
        $messages = $this->getMessageManager()->findAll();
        $this->getResponse($messages);
    }

    /**
     * add new message
     */
    public function add()
    {
        $message = $this->getMessageManager()->addMessage($this->getRequestData()['message'], $this->getUser()->id);
        $this->getResponse(array('text' => $message->text, 'user' => array('name' => $message->name)));
    }
}