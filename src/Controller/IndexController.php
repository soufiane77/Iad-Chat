<?php

namespace App\Controller;

use App\Services\UserManager;

class IndexController extends BaseController
{
    /**
     * login function
     * @param array $data
     * @return array
     */
    public function login()
    {
        $data = $this->getRequestData();

        if (empty(trim($data['name']))) {
            $this->getResponse('Invalid user name', 400);
        } else {
            $user = $this->getUserManager()->findOneByName($data['name']);
            if (!$user) {
                $user = $this->getUserManager()->insertUser(trim($data['name']));
            }
            $_SESSION['uid'] = $user->id;
            $this->getResponse($user);
        }
    }

    /**
     * function get current user connected
     * @param none
     * @return array
     */
    public function ping()
    {
        $user = $this->getUser();

        $this->getResponse($user);
    }

    /**
     *  function logout
     */
    public function logout()
    {
        session_unset();
        session_destroy();

        $this->getResponse('ok');
    }
}