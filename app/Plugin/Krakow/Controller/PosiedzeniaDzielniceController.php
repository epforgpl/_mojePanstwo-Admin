<?php

class PosiedzeniaDzielniceController extends KrakowAppController {

    public $components = array('Paginator');

    public $uses = array(
        'Krakow.RadyDzielnicePosiedzenia',
        'Krakow.Osoby',
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
            'RadyDzielnicePosiedzenia' => array(
                'fields' => array(
                    'RadyDzielnicePosiedzenia.*',
                    'Dzielnice.nazwa'
                ),
                'limit' => 25,
                'order' => array('date' => 'desc'),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'pl_dzielnice',
                        'alias' => 'Dzielnice',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'RadyDzielnicePosiedzenia.dzielnica_id = Dzielnice.id'
                        )
                    )
                )
            )
        );

        $data = $this->Paginator->paginate('RadyDzielnicePosiedzenia');
        $this->set('data', $data);
    }

    public function view($id) {
        if(isset($this->data) && is_array($this->data) && count($this->data) > 0) {
            return $this->json(array(
                'success' => $this->RadyDzielnicePosiedzenia->saveData($id, $this->data)
            ));
        }

        $data = $this->RadyDzielnicePosiedzenia->getData($id);
        if(!$data)
            throw new NotFoundException;

        $debaty = str_replace("'", "", json_encode($data['debaty']));
        $this->set('posiedzenie', $data['posiedzenie']);
        $this->set('debaty', $debaty);
    }

}