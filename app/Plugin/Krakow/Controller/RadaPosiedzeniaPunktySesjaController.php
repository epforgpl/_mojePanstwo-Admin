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

    public function edit($id) {
        return $this->json(array(
            'success' => $this->Punkty->saveData($id, $this->data)
        ));
    }

}