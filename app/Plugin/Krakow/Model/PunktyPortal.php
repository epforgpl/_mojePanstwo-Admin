<?php

App::uses('AppModel', 'Model');

class PunktyPortal extends AppModel {

    public $useTable = 'pl_gminy_krakow_posiedzenia_punkty_portal';

    /**
     * Usuwanie wszystkich punktów dla danego posiedzenia.
     *
     * Zapisywanie danych do tabeli punkty_portal na podstawie
     * tabeli punkty lub punkty_bip w zależności od dostarczonych
     * danych.
     *
     * @param $posiedzenie_id int Posiedzenie id
     * @param $data array Punkty
     * @return bool sukces?
     */
    public function addFromJoins($posiedzenie_id, $data) {
        $results = true;

        ClassRegistry::init('Krakow.Punkty');
        ClassRegistry::init('Krakow.PunktyBip');

        $Punkty = new Punkty();
        $PunktyBip = new PunktyBip();

        $doNotDelete = array();

        foreach($data as $row) {
            $toSave = array();
            switch($row['source']) {
                case 'bip':
                    $bip_id = $row['id'];

                    $punktBip = $PunktyBip->find('first', array(
                        'conditions' => array(
                            'PunktyBip.posiedzenie_id' => $posiedzenie_id,
                            'PunktyBip.id' => $bip_id
                        ),
                    ));

                    $toSave = $punktBip['PunktyBip'];
                    $toSave['punkt_bip_id'] = $bip_id;
                break;

                case 'panel':
                    $id = $row['id'];

                    $punkt = $Punkty->find('first', array(
                        'conditions' => array(
                            'Punkty.posiedzenie_id' => $posiedzenie_id,
                            'Punkty.id' => $id
                        ),
                    ));

                    $toSave = $punkt['Punkty'];
                    $toSave['punkt_id'] = $id;
                break;

                case 'panel_bip':
                    $bip_id = $row['id'];
                    $id = $row['punkt_id'];

                    $punktBip = $PunktyBip->find('first', array(
                        'conditions' => array(
                            'PunktyBip.posiedzenie_id' => $posiedzenie_id,
                            'PunktyBip.id' => $bip_id
                        ),
                    ));

                    $toSave = $punktBip['PunktyBip'];
                    $toSave['punkt_id'] = $id;
                    $toSave['punkt_bip_id'] = $bip_id;
                break;
                default: break;
            }

            if(count($toSave) > 0) {

                $id = $this->field(
                    'id',
                    array(
                        'posiedzenie_id' => $posiedzenie_id,
                        'punkt_id' => isset($toSave['punkt_id']) ? $toSave['punkt_id'] : 0,
                        'punkt_bip_id' => isset($toSave['punkt_bip_id']) ? $toSave['punkt_bip_id'] : 0
                    )
                );

                if($id)
                    $toSave['id'] = $id;
                else
                    unset($toSave['id']);

                $toSave['ord_panel'] = $row['ord'];
                $this->create();
                $this->save($toSave);
                $id = $this->getInsertID();

                $doNotDelete[] = $id;
            }
        }

        $punkty = $this->find('all', array(
            'posiedzenie_id' => $posiedzenie_id,
        ));

        foreach($punkty as $punkt) {
            if(!in_array($punkty['PunktyPortal']['id'], $doNotDelete))
                $this->delete($punkty['PunktyPortal']['id']);
        }

        return $results;
    }

}