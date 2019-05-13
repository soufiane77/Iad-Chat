<?php

namespace App\Controller;

use App\Entity\User;

class UserController extends BaseController
{
    /**
     * add new user
     */
    public function add()
    {
        $data = $this->getRequestData();
        $user = $this->getUserManager()->insertUser($data['name']);
        $this->getResponse($user);
    }
}