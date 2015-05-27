<?php

class RadaPosiedzeniaPunktySesjaController extends KrakowAppController {

    public $uses = array(
        'Krakow.Punkty',
        'PLText',
    );

    public function view($id) {
        $data = $this->Punkty->getData($id);
        $this->set('data', $data);
    }

}