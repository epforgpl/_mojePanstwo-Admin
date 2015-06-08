<?php

class UploadSessionsController extends KrakowAppController {

    public $uses = array(
        'Krakow.Komisje',
        'Krakow.Dzielnice',
        'Krakow.UploadSessions',
        'Krakow.UploadFiles',
        'PLText'
    );

    public function addForm() {
        if(isset($this->data) && is_array($this->data) && count($this->data) > 0) {
            return $this->json(
                $this->UploadSessions->createFromForm($this->data, $this->Auth->user('id'))
            );
        }

        $komisje = $this->Komisje->find('all', array(
            'conditions' => array(
                'Komisje.kadencja_7' => '1'
            ),
            'order' => array(
                'Komisje.nazwa'
            ),
        ));

        $dzielnice = $this->Dzielnice->find('all', array(
            'conditions' => array(
                'Dzielnice.pl_gminy_id' => 903
            ),
            'order' => array(
                'Dzielnice.nazwa'
            ),
        ));

        $this->set('komisje', $komisje);
        $this->set('dzielnice', $dzielnice);
    }

    public function view($id) {
        $session = $this->UploadSessions->findById($id);
        if(!$session)
            throw new NotFoundException;

        $config = Configure::read('Amazonsdk.credentials');
        unset($config['secret']);

        $files = $this->UploadFiles->getFiles($id);

        $this->set('config', json_encode($config));
        $this->set('files', $files);
        $this->set('session', $session);
    }

    public function uploadSuccess($id) {
        $session = $this->UploadSessions->findById($id);
        if(!$session)
            throw new NotFoundException;

        $this->UploadFiles->create();
        $this->UploadFiles->save(array(
            'session_id' => $session['UploadSessions']['id'],
            'session_hash' => $session['UploadSessions']['hash'],
            'key' => $this->data['key'],
            'uuid' => $this->data['uuid'],
            'name' => $this->data['name'],
            'bucket' => $this->data['bucket'],
            'etag' => $this->data['etag'],
            'ip' => $_SERVER['REMOTE_ADDR']
        ));

        $count = $this->UploadFiles->find('count', array(
            'conditions' => array(
                'UploadFiles.session_id' => $session['UploadSessions']['id'],
            ),
        ));

        $this->UploadSessions->id = $session['UploadSessions']['id'];
        $this->UploadSessions->save(array(
            'files_count' => $count
        ));

        $this->json(array(
            'success' => true
        ));
    }

}