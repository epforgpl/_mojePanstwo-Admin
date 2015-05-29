<?php

class UsersController extends AppController {

    public function opauth_complete() {
        $user = array(
            'id'    => $this->data['auth']['uid'],
            'email' => $this->data['auth']['info']['email'],
            'username' => $this->data['auth']['info']['name']
        );

        if($this->Auth->login($user)) {
            $this->redirect(
                $this->Auth->redirectUrl()
            );
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->redirect(
            $this->Auth->logoutRedirect
        );
    }

}