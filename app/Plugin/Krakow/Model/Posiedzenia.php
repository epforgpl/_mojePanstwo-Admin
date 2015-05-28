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

    /**
     * Dla importu:
     * Tworzenie punktów wynikowych na podstawie Punkty oraz PunktyBip.
     * Możliwe dopasowanie punktów. Niedopasowane punkty są dodawane.
     * Łączenie punktów za pomocą PunktyPortal.
     *
     * Dla braku importu:
     * Wczytywanie punktów z PunktyPortal.
     *
     * @param $id int Posiedzenie id
     * @param $import bool Czy importować dane?
     * @return array Punkty wynikowe
     */
    public function joinPoints($id, $import = false) {
        $results = array();

        ClassRegistry::init('Krakow.Punkty');
        ClassRegistry::init('Krakow.PunktyBip');
        ClassRegistry::init('Krakow.PunktyPortal');

        $Punkty = new Punkty();
        $PunktyBip = new PunktyBip();
        $PunktyPortal = new PunktyPortal();

        $punktyPortal = $PunktyPortal->find('all', array(
            'conditions' => array(
                'PunktyPortal.posiedzenie_id' => $id,
                'PunktyPortal.deleted' => '0'
            ),
            'order' => array(
                'PunktyPortal.ord_panel'
            ),
        ));

        if(!$import && !count($punktyPortal))
            return array();

        $punkty = $Punkty->find('all', array(
            'conditions' => array(
                'Punkty.posiedzenie_id' => $id,
                //'Punkty.deleted LIKE' => '0'
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

        // przygotowanie punktów do połączenia
        foreach($punkty as $i => $punkt)
            $punkty[$i] = $this->_preparePointToJoin($punkt, 'Punkty');
        foreach($punktyBip as $i => $punkt)
            $punktyBip[$i] = $this->_preparePointToJoin($punkt, 'PunktyBip');
        if($punktyPortal)
            foreach($punktyPortal as $i => $punkt)
                $punktyPortal[$i] = $this->_preparePointToJoin($punkt, 'PunktyPortal', true);

        // łączenie punktów
        foreach($punktyBip as $i => $punktBip) {
            $punkt_id = 0;
            unset($_punkt);
            foreach($punkty as $j => $punkt) {
                // czy punkt został już połączony?
                if(isset($punkty[$j]['found']) && $punkty[$j]['found'])
                    continue;

                /* if($punktBip['nr'] == '12') {
                    echo '<h1>Bip</h1><pre>';
                    var_export($punktBip);
                    echo '</pre>';
                }
                if($punktBip['nr'] == '12') {
                    echo '<h1>Bip</h1><pre>';
                    var_export($punktBip);
                    echo '</pre>';
                }

                if($punkt['nr'] == '12') {
                    echo '<h1>Panel</h1><pre>';
                    var_export($punkt);
                    die();
                } */

                // po numerze druku
                if($punktBip['druki_nr'] > 0 && ($punktBip['druki_nr'] == $punkt['druki_nr'])) {
                    $punkty[$j]['found'] = true;
                    $punkt_id = $punkt['id'];
                    $_punkt = $punkt;
                    break;
                }

                // po tytule (hash)
                if($punktBip['hash'] == $punkt['hash']) {
                    $punkty[$j]['found'] = true;
                    $punkt_id = $punkt['id'];
                    $_punkt = $punkt;
                    break;
                }

                // po opisie (hash)
                if($punktBip['hash_opis']!= '' && $punktBip['hash_opis'] == $punkt['hash_opis']) {
                    $punkty[$j]['found'] = true;
                    $punkt_id = $punkt['id'];
                    $_punkt = $punkt;
                    break;
                }
            }

            // znaleziono połączenie
            if($punkt_id && isset($_punkt)) {
                $punktyBip[$i]['source'] = 'bip';
                //$punktyBip[$i]['punkt_id'] = $punkt_id;
                $_punkt['source'] = 'panel';
                $punktyBip[$i]['child'] = $_punkt;
            } else {
                $punktyBip[$i]['source'] = 'bip';
            }

            $results[] = $punktyBip[$i];
        }

        // dodanie niepołączonych punktów
        foreach($punkty as $j => $punkt) {
            // czy punkt nie został wcześniej połączony?
            if(!isset($punkty[$j]['found'])) {
                $punkty[$j]['source'] = 'panel';
                $results[] = $punkty[$j];
            }
        }

        usort($results, function($a, $b) {
            return (int) $a['nr'] > (int) $b['nr'];
        });

        // dodatkowe sortowanie punktów które nie posiadają numeru np. 'Blok głosowań'
        foreach($results as $i => $row) {
            if($row['nr'] == '') {
                foreach($punkty as $p => $punkt) {
                    if($punkt['id'] == $row['id']) {
                        if(isset($punkty[$p - 1])) {
                            unset($results[$i]);
                            array_splice($results, $p, 0, array($row));
                        }
                    }
                }
            }
        }

        // łączenie punktów zapisanych przez użytkownika
        if(!$import && $punktyPortal) {
            foreach($punktyPortal as $i => $punktPortal) {
                if($punktPortal['punkt_id'] > 0 && $punktPortal['punkt_bip_id'] > 0) {
                    // usunięcie punkt_id z $results jeżeli istnieje (jako pojedyńczy)
                    // i dodanie go jako podrzędnego w punkt_bip_id
                    foreach($results as $r => $row) {
                        if($row['id'] == $punktPortal['punkt_id'] && $row['source'] == 'panel') {
                            unset($results[$r]);
                        }

                        if($row['id'] == $punktPortal['punkt_bip_id'] && $row['source'] == 'bip') {
                            $results[$r]['punkt_id'] = $punktPortal['punkt_id'];
                            $results[$r]['source'] = 'panel_bip';
                        }
                    }
                }
            }

            // usunięcie punktów
            foreach($results as $r => $row) {
                $isset = false;
                foreach($punktyPortal as $i => $punktPortal) {
                    if($row['source'] == 'panel_bip' && $row['id'] == $punktPortal['punkt_bip_id'] && $row['punkt_id'] == $punktPortal['punkt_id'])
                        $isset = true;

                    if($row['source'] == 'panel' && $row['id'] == $punktPortal['punkt_id']) {
                        $isset = true;
                    }

                    if($row['source'] == 'bip' && $row['id'] == $punktPortal['punkt_bip_id']) {
                        $isset = true;
                    }
                }

                if(!$isset)
                    unset($results[$r]);
            }
        }

        if($import && $punktyPortal) {
            foreach($punktyPortal as $i => $punktPortal) {
                $found = false;
                if($punktPortal['punkt_id'] > 0 && $punktPortal['punkt_bip_id'] > 0) {
                    foreach($results as $r => $row) {
                        if($row['id'] == $punktPortal['punkt_bip_id'] && $row['source'] == 'bip') {
                            // znaleźliśmy punkt_bip_id do którego jako child trzeba dodać punkt_id
                            // a punkt_id trzeba wywalić z tablicy results
                            foreach($results as $r2 => $row2) {
                                if($row2['source'] == 'panel' && $row2['id'] == $punktPortal['punkt_id']) {
                                    $results[$r]['child'] = $row2;
                                    unset($results[$r2]);
                                    $found = true;
                                    break;
                                }
                            }
                        }

                        if($found)
                            break;
                    }
                }
            }
        }

        return $results;
    }

    /**
     * Przygotowywanie punktu do połączenia. Utworzenie `hash`, `druki_nr`, `hash_opis`.
     *
     * @param $point array Punkt
     * @param $name string Nazwa modelu
     * @param $haveChilds bool Czy punkt zawiera punkt_id lub punkt_bip_id
     * @return array Punkt
     */
    private function _preparePointToJoin($point, $name, $haveChilds = false) {
        $p = array(
            'id' => $point[$name]['id'],
            'nr' => $point[$name]['nr'],
            'tytul' => $point[$name][$name == 'Punkty' ? 'tytul' : 'tytul_pelny'],
            'match_id' => 0
        );

        if($haveChilds)
            $p = array_merge($p, array(
                'punkt_id' => $point[$name]['punkt_id'],
                'punkt_bip_id' => $point[$name]['punkt_bip_id']
            ));

        $opis = '';
        $druki_str = '';
        $druki_nr = 0;
        $parts = explode('/ ', $p['tytul']);
        $parts = array_filter($parts, 'strlen');
        if(count($parts) > 1) {
            if(count($parts) == 3) {
                $tytul = @$parts[0];
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

        $pattern = '/[^a-zA-Z0-9]+/';

        $p['hash'] = strtolower(
            preg_replace($pattern, '', trim(isset($tytul) ? $tytul : $p['tytul']))
        );

        $p['hash_opis'] = strtolower(
            preg_replace($pattern, '', trim($p['opis']))
        );

        $p['child'] = false;

        return $p;
    }

}