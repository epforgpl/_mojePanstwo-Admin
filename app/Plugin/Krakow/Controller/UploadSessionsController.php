<?php

class UploadSessionsController extends KrakowAppController {

    public $uses = array(
        'Krakow.Komisje',
        'Krakow.Dzielnice'
    );

    public function addForm() {
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

}