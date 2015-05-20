<?php

App::uses('AppModel', 'Model');

class Punkty extends AppModel {

    public $useTable = 'pl_gminy_krakow_posiedzenia_punkty';

    public function getPlan($date) {
        return $this->getDataSource()->fetchAll(
            'SELECT id, nr, tytul FROM pl_gminy_krakow_posiedzenia_punkty_plan WHERE posiedzenie_data = ? ORDER BY nr ASC',
            array(addslashes($date))
        );
    }

}