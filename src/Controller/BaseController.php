<?php

namespace App\Controller;

use App\Services\MessageManager;
use App\Services\UserManager;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class BaseController {

    /**
     * @var SerializerInterface
     */
    private $serializer;

    private $userManager;

    private $messageManager;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->userManager = new UserManager();
        $this->messageManager = new MessageManager();
    }

    public function getUserManager() {
        return $this->userManager;
    }

    public function getMessageManager() {
        return $this->messageManager;
    }

    public function getResponse($data, $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        $jsonContent = $this->serializer->serialize($data, 'json');

        echo $jsonContent;
        die();
    }


    public function getRequestData(): ?array
    {
        $entityBody = file_get_contents('php://input');

        try {
            return $this->serializer->deserialize($entityBody, 'array', 'json');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getUser()
    {
        $user = $this->userManager->findOneById($_SESSION['uid']);

        if (is_null($user)) {
            $this->getResponse('User not connected', 403);
        }

        return $user;
    }

}