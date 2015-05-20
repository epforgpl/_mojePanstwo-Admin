<?php

class RadaPosiedzeniaController extends KrakowAppController {

    public $components = array('RequestHandler');

    public $uses = array(
        'Krakow.Posiedzenia',
        'Krakow.Punkty',
        'Krakow.Wystapienia',
    );

    public function index() {
        $this->set('posiedzenia', $this->Posiedzenia->find('all'));
    }

    public function view($id) {
        $data = $this->Posiedzenia->getData($id);
        if(!$data)
            throw new NotFoundException;

        $this->set('posiedzenie', $data['posiedzenie']);
        $this->set('punkty', json_encode($data['punkty']));
    }

    public function editForm($id) {
        $data = $this->Posiedzenia->getData($id);
        if(!$data)
            throw new NotFoundException;

        $this->set('posiedzenie', $data['posiedzenie']);
        $this->set('punkty', json_encode($data['punkty']));
    }

    public function edit($id) {
        $success = (bool) $this->Posiedzenia->saveData($id, $this->data);
        $this->json($success);
    }

    public function importData() {
        if(!$this->data['date'])
            throw new BadRequestException;

        $_data = array();
        $results = $this->Punkty->getPlan(
            $this->data['date']
        );

        foreach($results as $k => $row)
            $_data[] = array_values($row);

        $this->json($_data);
    }

}