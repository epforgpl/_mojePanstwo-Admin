<?php

class RadaPosiedzeniaController extends KrakowAppController {

    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Krakow.Posiedzenia',
        'Krakow.Punkty',
        'Krakow.PunktyBip',
        'Krakow.PunktyPortal',
        'Krakow.Wystapienia',
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
            $conditions = array('porzadek_akcept LIKE' => '1');
        else if($mode == 'notaccepted')
            $conditions = array('porzadek_akcept LIKE' => '0');

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Posiedzenia' => array(
                'limit' => 25,
                'order' => array('date' => 'desc'),
                'conditions' => $conditions,
            )
        );

        $data = $this->Paginator->paginate('Posiedzenia');
        $this->set('data', $data);
    }

    public function view($id) {
        $posiedzenie = $this->Posiedzenia->findByIdWithClosest($id);
        if(!$posiedzenie)
            throw new NotFoundException;

        $this->set('posiedzenie', $posiedzenie);
        $this->set('punkty', $this->Posiedzenia->joinPoints($id));
    }

    public function editForm($id) {
        $data = $this->Posiedzenia->getData($id);
        if(!$data)
            throw new NotFoundException;

        $punkty = str_replace("'", "", json_encode($data['punkty']));
        $this->set('posiedzenie', $data['posiedzenie']);
        $this->set('punkty', $punkty);
    }

    public function import($id) {
        if(isset($this->data) && is_array($this->data) && count($this->data) > 0) {
            return $this->json(array(
                'success' => $this->PunktyPortal->addFromJoins($id, $this->data)
            ));
        }

        $posiedzenie = $this->Posiedzenia->findByIdWithClosest($id);
        if(!$posiedzenie)
            throw new NotFoundException;

        $this->set('punkty', $this->Posiedzenia->joinPoints($id, true));
        $this->set('posiedzenie', $posiedzenie);
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