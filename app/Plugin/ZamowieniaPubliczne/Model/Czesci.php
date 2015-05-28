<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 28/05/15
 * Time: 12:38
 */


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