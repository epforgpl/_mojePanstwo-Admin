<?php

class UploadSessionsController extends KrakowAppController {

    public $uses = array(
        'Krakow.Komisje',
        'Krakow.Dzielnice',
        'Krakow.UploadSessions',
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

    public function addFilesForm($id) {
        $session = $this->UploadSessions->findById($id);
        if(!$session)
            throw new NotFoundException;

        $this->set('session', $session);
    }

}