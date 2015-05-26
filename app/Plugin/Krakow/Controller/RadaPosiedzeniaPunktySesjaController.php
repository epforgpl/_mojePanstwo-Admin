<?php

class RadaPosiedzeniaPunktySesjaController extends KrakowAppController {

    public $uses = array(
        'Krakow.Posiedzenia',
        'Krakow.Punkty',
        'Krakow.UploadSessions',
        'Krakow.UploadFiles',
        'Krakow.RadyPosiedzeniaPliki',
        'PLText',
    );

    public function view($id) {
        $data = $this->Punkty->getData($id);
        $this->set('data', $data);
    }

}