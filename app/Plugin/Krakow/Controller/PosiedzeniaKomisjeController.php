<?php

class PosiedzeniaKomisjeController extends KrakowAppController {

    public $components = array('Paginator');

    public $uses = array(
        'Krakow.RadyKomisjePosiedzenia',
        'Krakow.RadyKomisjePosiedzeniaDebaty',
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
            'RadyKomisjePosiedzenia' => array(
                'fields' => array(
                    'RadyKomisjePosiedzenia.*',
                    'Komisje.nazwa'
                ),
                'limit' => 25,
                'order' => array('date' => 'desc'),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'rady_komisje',
                        'alias' => 'Komisje',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'RadyKomisjePosiedzenia.komisja_id = Komisje.id'
                        )
                    )
                )
            )
        );

        $data = $this->Paginator->paginate('RadyKomisjePosiedzenia');
        $this->set('data', $data);
    }

    public function view($id) {
        if(isset($this->data) && is_array($this->data) && count($this->data) > 0) {
            return $this->json(array(
                'success' => $this->RadyKomisjePosiedzenia->saveData($id, $this->data)
            ));
        }

        $data = $this->RadyKomisjePosiedzenia->getData($id);
        if(!$data)
            throw new NotFoundException;

        $debaty = str_replace("'", "", json_encode($data['debaty']));
        $this->set('posiedzenie', $data['posiedzenie']);
        $this->set('debaty', $debaty);
    }

    public function getAutocompleteMowcy() {
        $q = $this->request->query['query'];
        $suggestions = array();

        $results = $this->Osoby->find('all', array(
            'fields' => array(
                'Osoby.nazwa',
                'Osoby.id',
                'Osoby.opis'
            ),
            'limit' => 5,
            'conditions' => array(
                'Osoby.nazwa LIKE' => "%$q%",
                'Osoby.akcept LIKE' => '1'
            )
        ));

        foreach($results as $row) {
            $suggestions[] = array(
                'value' => $row['Osoby']['nazwa'] . ' ('.$row['Osoby']['opis'].')',
                'id' => $row['Osoby']['id']
            );
        }

        $this->json(array(
            'query' => $q,
            'suggestions' => $suggestions
        ));
    }

}