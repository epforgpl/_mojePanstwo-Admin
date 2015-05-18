<?php

class UsersController extends AppController {

    public function opauth_complete() {
        $email = $this->data['auth']['info']['email'];

        $user = array(
            'email' => $email
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