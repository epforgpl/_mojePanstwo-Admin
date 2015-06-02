<?php

class RadaPosiedzeniaPunktySesjaController extends KrakowAppController {

    public $components = array('Paginator');

    public $uses = array(
        'Krakow.Punkty',
        'PLText',
        'Paginator'
    );

    public function index() {
        $modes = array(
            'all' => 'Wszystkie',
            'accepted' => 'Zaakceptowane',
            'notaccepted' => 'Do zaakceptowania'
        );

        $mode = in_array(@$this->params['url']['mode'], array_keys($modes))
            ? $this->params['url']['mode'] : 'all';

        $this->set('modes', $modes);
        $this->set('mode', $mode);

        $conditions = array();
        if($mode == 'accepted')
            $conditions = array('wystapienia_akcept LIKE' => '1');
        else if($mode == 'notaccepted')
            $conditions = array('wystapienia_akcept LIKE' => '0');

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Punkty' => array(
                'limit' => 25,
                'order' => array('date' => 'desc'),
                'conditions' => $conditions,
            )
        );

        $data = $this->Paginator->paginate('Punkty');
        $this->set('data', $data);
    }

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