<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 01/06/15
 * Time: 14:42
 */

App::uses('AppModel', 'Model');

class Dzialy extends AppModel {

    public $useTable = 'msig_dzialy';

    public function getDzialy($id) {
        return $this->getDataSource()->fetchAll(
            'SELECT id, nazwa, strona_od, strona_do, liczba_stron FROM msig_dzialy WHERE wydanie_id = ? ORDER BY nazwa ASC',
            array($id)
        );
    }

}