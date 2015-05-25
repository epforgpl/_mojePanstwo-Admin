<?php

App::uses('AppModel', 'Model');

class Posiedzenia extends AppModel {

    public $useTable = 'pl_gminy_krakow_posiedzenia';

    public function findByIdWithClosest($id) {
        $posiedzenie = $this->findById($id);
        if(!$posiedzenie)
            return false;

        $posiedzenieNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Posiedzenia.date >' => $posiedzenie['Posiedzenia']['date']
            ),
            'order' => array(
                'Posiedzenia.date' => 'asc'
            ),
        ));

        $posiedzeniePrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Posiedzenia.date <' => $posiedzenie['Posiedzenia']['date']
            ),
            'order' => array(
                'Posiedzenia.date' => 'desc'
            ),
        ));

        $posiedzenie['Posiedzenia']['next'] = count($posiedzenieNext) > 0 ? $posiedzenieNext : false;
        $posiedzenie['Posiedzenia']['prev'] = count($posiedzeniePrev) > 0 ? $posiedzeniePrev : false;

        return $posiedzenie;
    }

    /**
     * @param $id int Posiedzenie
     * @return array Wszystkie dane posiedzenia
     */
    public function getData($id)
    {
        $posiedzenie = $this->findByIdWithClosest($id);
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
                'Punkty.deleted NOT LIKE' => '1'
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
                    'Wystapienia.deleted NOT LIKE'   => '1'
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
            'posiedzenie'       => $posiedzenie,
            'punkty'            => $data
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

    public function joinPoints($id) {
        ClassRegistry::init('Krakow.Punkty');
        ClassRegistry::init('Krakow.PunktyBip');

        $Punkty = new Punkty();
        $PunktyBip = new PunktyBip();

        $punkty = $Punkty->find('all', array(
            'conditions' => array(
                'Punkty.posiedzenie_id' => $id,
                'Punkty.deleted LIKE' => '0'
            ),
            'order' => array(
                'Punkty.ord_panel'
            ),
        ));

        $punktyBip = $PunktyBip->find('all', array(
            'conditions' => array(
                'PunktyBip.posiedzenie_id' => $id,
                'PunktyBip.deleted LIKE' => '0'
            ),
            'order' => array(
                'PunktyBip.ord_panel'
            ),
        ));

        $_punkty = array();
        foreach($punkty as $punkt) {
            $p = $this->_preparePointToJoin($punkt, 'Punkty');
            $_punkty[] = $p;
        }

        $_punktyBip = array();
        foreach($punktyBip as $punkt) {
            $p = $this->_preparePointToJoin($punkt, 'PunktyBip');
            $_punktyBip[] = $p;
        }

        foreach($_punktyBip as $i => $b) {
            $_id = 0;
            foreach($_punkty as $a) {
                if($b['druki_nr'] > 0 && $b['druki_nr'] == $a['druki_nr']) {
                    $_id = $a['id'];
                    break;
                }

                if($b['hash'] == $a['hash']) {
                    $_id = $a['id'];
                    break;
                }
            }

            $_punktyBip[$i]['match_id'] = $_id;
        }

        foreach($_punkty as $i => $a) {
            $_id = 0;
            foreach($_punktyBip as $b) {
                if($b['druki_nr'] > 0 && $b['druki_nr'] == $a['druki_nr']) {
                    $_id = $b['id'];
                    break;
                }

                if($a['hash'] == $b['hash']) {
                    $_id = $b['id'];
                    break;
                }
            }

            $_punkty[$i]['match_id'] = $_id;
        }

        $results = array();
        foreach($_punktyBip as $i => $b) {

            $punkt = array();
            foreach($_punkty as $_p) {
                if($b['match_id'] == $_p['id']) {
                    $punkt = $_p;
                    break;
                }
            }

            $_punktyBip[$i]['panel_id'] = isset($punkt['id']) ? $punkt['id'] : 0;
            $_punktyBip[$i]['bip_id'] = $b['id'];
            $results[] = $_punktyBip[$i];
        }

        return $results;
    }

    private function _preparePointToJoin($point, $name) {
        $p = array(
            'id' => $point[$name]['id'],
            'nr' => $point[$name]['nr'],
            'tytul' => $point[$name][$name == 'Punkty' ? 'tytul' : 'tytul_pelny'],
            'match_id' => 0
        );

        $opis = '';
        $druki_str = '';
        $druki_nr = 0;
        $parts = explode('/ ', $p['tytul']);
        $parts = array_filter($parts, 'strlen');
        if(count($parts) > 1) {
            if(count($parts) == 3) {
                $opis = @$parts[1];
                $druki_str = $parts[2];
                if(preg_match('/([0-9]{1,})/', $druki_str, $matches ) ) {
                    $druki_nr = (int) $matches[0];
                }
            } else {

            }
        }

        $p['opis'] = $opis;
        $p['druki_str'] = $druki_str;
        $p['druki_nr'] = $druki_nr;

        $p['hash'] = strtolower(
            preg_replace('/(\s+|\'|\\|\.|\,|\")/', '', trim($p['tytul']))
        );

        return $p;
    }

}