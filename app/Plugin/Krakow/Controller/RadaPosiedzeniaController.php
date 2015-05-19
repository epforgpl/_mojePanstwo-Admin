<?php

class RadaPosiedzeniaController extends KrakowAppController {

    public $uses = array('Krakow.Posiedzenia');

    public function index() {
        $this->set('posiedzenia', $this->Posiedzenia->find('all'));
    }

    public function view($id) {
        $posiedzenie = $this->Posiedzenia->findById($id);
        if(!$posiedzenie)
            throw new NotFoundException();

        $this->set('posiedzenie', $posiedzenie);
    }

}