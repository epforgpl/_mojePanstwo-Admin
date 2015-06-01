<?php

class UsersController extends AppController {

    private static $errors = array(
        'Wystąpił błąd',
        'Nie posiadasz uprawnień administratora'
    );

    public function opauth_complete() {

        try {
            if(!isset($this->data['auth']['raw']))
                throw new Exception(self::$errors[0]);

            $user = $this->data['auth']['raw'];
            if(!isset($user['admin_groups']) || !count($user['admin_groups']))
                throw new Exception(self::$errors[1]);

            if($this->Auth->login($user)) {
                $this->redirect(
                    $this->Auth->redirectUrl()
                );
            }
        } catch(Exception $e) {
            $this->Session->setFlash($e->getMessage(), 'default', array(), 'auth_error');
            $this->redirect('/');
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->redirect(
            $this->Auth->logoutRedirect
        );
    }

}