<?php

App::uses('AppModel', 'Model');

class Czesci extends AppModel {

    public $useTable = 'uzp_czesci';

    public function getCzesci($id) {
        return $this->getDataSource()->fetchAll(
            'SELECT id, numer, nazwa, data_zam, cena, cena_min, cena_max FROM uzp_czesci WHERE dokument_id = ? ORDER BY numer ASC',
            array($id)
        );
    }

}