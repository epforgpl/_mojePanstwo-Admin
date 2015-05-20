<?php

App::uses('AppModel', 'Model');

class Posiedzenia extends AppModel {

    public $useTable = 'pl_gminy_krakow_posiedzenia';

    /**
     * @param $id int Posiedzenie
     * @return array Wszystkie dane posiedzenia
     */
    public function getData($id)
    {
        $posiedzenie = $this->findById($id);
        if(!$posiedzenie)
            return false;

        ClassRegistry::init('Krakow.Punkty');
        ClassRegistry::init('Krakow.Wystapienia');

        $Punkty = new Punkty();
        $Wystapienia = new Wystapienia();

        $data = array();

        $punkty = $Punkty->find('all', array(
            'conditions' => array(
                'Punkty.posiedzenie_id' => $id,
                'Punkty.deleted'        => '0'
            ),
            'order' => array(
                'Punkty.ord_panel'
            ),
        ));

        foreach($punkty as $punkt)
        {
            $osoby = array();
            $wystapienia = $Wystapienia->find('all', array(
                'conditions' => array(
                    'Wystapienia.punkt_id'  => $punkt['Punkty']['id'],
                    'Wystapienia.deleted'   => '0'
                ))
            );

            foreach($wystapienia as $row)
                $osoby[] = array(
                    'ord'           => $row['Wystapienia']['ord'],
                    'nazwa'         => $row['Wystapienia']['nazwa'],
                    'stanowisko'    => $row['Wystapienia']['stanowisko'],
                    'czas_str'      => $row['Wystapienia']['czas_str']
                );

            $data[] = array(
                'id'    => $punkt['Punkty']['id'],
                'tytul' => $punkt['Punkty']['tytul'],
                'nr'    => $punkt['Punkty']['nr'],
                'czas'  => $punkt['Punkty']['czas_str'],
                'ord'   => $punkt['Punkty']['ord'],
                'osoby' => $osoby
            );
        }

        return array(
            'posiedzenie'   => $posiedzenie,
            'punkty'        => $data
        );
    }

    /**
     * @param $id int Posiedzenie
     * @param $data array Dane
     * @return bool
     * @throws Exception
     */
    public function saveData($id, $data) {
        $posiedzenie = $this->findById($id);
        if(!$posiedzenie || !$data['points'])
            throw new NotFoundException();

        ClassRegistry::init('Krakow.Punkty');
        ClassRegistry::init('Krakow.Wystapienia');

        $Punkty = new Punkty();
        $Wystapienia = new Wystapienia();

        $Punkty->updateAll(
            array('Punkty.deleted' => '1'),
            array('Punkty.posiedzenie_id' => $posiedzenie['Posiedzenia']['id'])
        );

        $points = $data['points'];

        foreach($points as $pointOrd => $point) {
            $pointRow = array(
                'nr' => $point['nr'],
                'posiedzenie_id' => $id,
                'czas_str' => $point['czas'],
                'tytul' => $point['tytul'],
                'ord_panel' => $pointOrd,
                'deleted' => '0',
                'czas_akcept' => '0',
            );

            if(!$point['id']) {
                $_point = $Punkty->find('first', array(
                    'fields' => 'Punkty.id',
                    'conditions' => array(
                        'Punkty.posiedzenie_id' => $id,
                        'Punkty.nr' => $point['nr'],
                    )
                ));

                if(isset($_point['Punkty']['id']))
                    $point['id'] = $_point['Punkty']['id'];
            }

            if(!$point['id']) {
                $Punkty->save(array(
                    'Punkty' => $pointRow
                ));
                $pointRow['id'] = $Punkty->id;
            } else {
                $pointRow['id'] = $point['id'];
                $Punkty->id = $point['id'];
                $Punkty->save($pointRow);
            }

            $Wystapienia->updateAll(
                array('Wystapienia.deleted' => '1'),
                array('Wystapienia.punkt_id' => $pointRow['id'])
            );

            if(isset($point['osoby']) && is_array($point['osoby']) && count($point['osoby']) > 0)
            {
                $osoby = $point['osoby'];

                foreach($osoby as $osobaOrd => $osoba)
                {
                    $osobaRow = array(
                        'punkt_id'      => $pointRow['id'],
                        'ord'           => $osobaOrd,
                        'nazwa'         => $osoba['nazwa'],
                        'stanowisko'    => $osoba['stanowisko'],
                        'czas_str'          => $osoba['czas'],
                        'deleted'       => '0'
                    );

                    if(!$osoba['id']) {
                        $Wystapienia->save(array(
                            'Wystapienia' => $osobaRow
                        ));
                        $osobaRow['id'] = $Wystapienia->id;
                    } else {
                        $osobaRow['id'] = $osoba['id'];
                        $Wystapienia->id = $osoba['id'];
                        $Wystapienia->save($osobaRow);
                    }
                }
            }
        }

        $this->id = $id;
        $this->save(array(
            'porzadek_akcept' => '1'
        ));

        return true;
    }

}