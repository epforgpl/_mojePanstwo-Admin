<?php

class SettingsController extends AppController {

    public $uses = array(
        'DatabaseSync',
        'PLText'
    );

    public function setDatabase() {
        ClassRegistry::init('AppModel');
        if(!in_array(@$this->data['type'], array_keys(AppModel::$databaseTypes)))
            throw new NotFoundException;

        $this->Session->write('Database.type', $this->data['type']);

        $this->redirect(
            $this->referer()
        );
    }

    public function syncDatabase() {
        if(isset($this->data['sync'])) {
            App::import('Console/Command', 'DatabaseShell');
            $job = new DatabaseShell();
            $job->dispatchMethod('sync');

            $this->DatabaseSync->save(array(
                'DatabaseSync' => array(
                    'user_id' => $this->Auth->user('id'),
                    'username' => $this->Auth->user('username'),
                    'ip' => $this->request->clientIp()
                )
            ));

            $this->redirect(
                $this->referer()
            );
        }

        $this->set('lastSync', $this->DatabaseSync->find('first', array(
            'order' => array('DatabaseSync.created' => 'desc')
        )));
    }

}