<?php

App::uses('AppModel', 'Model');

class RadyKomisjePosiedzenia extends AppModel {

    public $useTable = 'rady_komisje_posiedzenia';

    public function findByIdWithClosest($id) {
        $posiedzenie = $this->findById($id);
        if(!$posiedzenie)
            return false;

        $posiedzenieNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'RadyKomisjePosiedzenia.date >' => $posiedzenie['RadyKomisjePosiedzenia']['date']
            ),
            'order' => array(
                'RadyKomisjePosiedzenia.date' => 'asc'
            ),
        ));

        $posiedzeniePrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'RadyKomisjePosiedzenia.date <' => $posiedzenie['RadyKomisjePosiedzenia']['date']
            ),
            'order' => array(
                'RadyKomisjePosiedzenia.date' => 'desc'
            ),
        ));

        $posiedzenie['RadyKomisjePosiedzenia']['next'] = count($posiedzenieNext) > 0 ? $posiedzenieNext : false;
        $posiedzenie['RadyKomisjePosiedzenia']['prev'] = count($posiedzeniePrev) > 0 ? $posiedzeniePrev : false;

        return $posiedzenie;
    }

    /**
     * Zapisuje dane z AJAX (post)
     *
     * @param $posiedzenie_id int
     * @param $data array
     * @return bool success
     */
    public function saveData($posiedzenie_id, $data) {
        if(is_array($data) && count($data) > 0) {

            $posiedzenie = $this->findByIdWithClosest($posiedzenie_id);

            if(!$posiedzenie)
                return false;

            ClassRegistry::init('Krakow.RadyKomisjePosiedzeniaDebaty');
            ClassRegistry::init('Krakow.RadyKomisjePosiedzeniaDebatyMowcy');

            $Debaty = new RadyKomisjePosiedzeniaDebaty();
            $Mowcy = new RadyKomisjePosiedzeniaDebatyMowcy();

            $dodanePunkty = array();

            foreach($data as $punkt) {

                $punkt_id = 0;
                if(strpos($punkt['id'], '_') === false) {
                    $punkt_id = $punkt['id'];
                    $Debaty->clear();
                    $Debaty->id = $punkt_id;
                    $Debaty->save(array(
                        'tytul' => $punkt['tytul'],
                        'video_start' => $punkt['video_start'],
                        'posiedzenie_id' => $posiedzenie_id,
                        'ord' => $punkt['ord']
                    ));
                } else {
                    $Debaty->clear();
                    $Debaty->save(array(
                        'tytul' => $punkt['tytul'],
                        'video_start' => $punkt['video_start'],
                        'posiedzenie_id' => $posiedzenie_id,
                        'ord' => $punkt['ord']
                    ));
                    $punkt_id = $Debaty->getInsertID();
                }

                $dodanePunkty[] = $punkt_id;

                $ord = 0;
                if(isset($punkt['mowcy']) && is_array($punkt['mowcy'])) {

                    $Mowcy->clear();
                    $Mowcy->updateAll(
                        array('deleted' => '1'),
                        array(
                            'punkt_id' => $punkt_id
                        )
                    );

                    foreach($punkt['mowcy'] as $mowca) {
                        $Mowcy->clear();
                        $isset = $Mowcy->field('osoba_id', array(
                            'ord' => $ord,
                            'punkt_id' => $punkt_id
                        ));

                        if ($isset === false) {
                            $Mowcy->clear();
                            $Mowcy->create();
                            $Mowcy->save(array(
                                'punkt_id' => $punkt_id,
                                'ord' => $ord,
                                'deleted' => '0',
                                'nazwa' => $mowca['nazwa'],
                                'osoba_id' => $mowca['id'],
                            ));
                        } else {
                            $Mowcy->clear();
                            $Mowcy->updateAll(array(
                                'deleted' => '0',
                                'nazwa' => '"'.$mowca['nazwa'].'"',
                                'osoba_id' => $mowca['id']
                            ), array(
                                'ord' => $ord,
                                'punkt_id' => $punkt_id
                            ));
                        }

                        $ord++;
                    }
                }
            }

            $Debaty->clear();
            $Debaty->updateAll(
                array('deleted' => '1'),
                array(
                    'posiedzenie_id' => $posiedzenie_id,
                    'NOT' => array(
                        'id' => $dodanePunkty
                    )
                )
            );
        }

        $this->id = $posiedzenie_id;
        $this->save(array(
            'porzadek_akcept' => '1',
            'analiza' => '1'
        ));

        return true;
    }

    /**
     * @param $id int Posiedzenie
     * @return array Wszystkie dane posiedzenia komisji
     */
    public function getData($id)
    {
        $posiedzenie = $this->findByIdWithClosest($id);

        if(!$posiedzenie)
            return false;

        ClassRegistry::init('Krakow.RadyKomisjePosiedzeniaDebaty');
        ClassRegistry::init('Krakow.RadyKomisjePosiedzeniaDebatyMowcy');

        $Debaty = new RadyKomisjePosiedzeniaDebaty();
        $Mowcy = new RadyKomisjePosiedzeniaDebatyMowcy();

        $data = array();

        $debaty = $Debaty->find('all', array(
            'conditions' => array(
                'RadyKomisjePosiedzeniaDebaty.posiedzenie_id' => $id,
                'RadyKomisjePosiedzeniaDebaty.deleted LIKE' => '0'
            ),
            'order' => array(
                'RadyKomisjePosiedzeniaDebaty.ord'
            ),
        ));

        $data = array();

        foreach($debaty as $debata) {
            $mowcy = array();
            $mowcySrc = $Mowcy->find('all', array(
                'conditions' => array(
                    'RadyKomisjePosiedzeniaDebatyMowcy.punkt_id' => $debata['RadyKomisjePosiedzeniaDebaty']['id'],
                    'RadyKomisjePosiedzeniaDebatyMowcy.deleted LIKE' => '0'
                ))
            );

            foreach($mowcySrc as $row) {
                $mowcy[] = array(
                    'id'            => $row['RadyKomisjePosiedzeniaDebatyMowcy']['osoba_id'],
                    'ord'           => $row['RadyKomisjePosiedzeniaDebatyMowcy']['ord'],
                    'nazwa'         => $row['RadyKomisjePosiedzeniaDebatyMowcy']['nazwa']
                );
            }

            $data[] = array(
                'id'            => $debata['RadyKomisjePosiedzeniaDebaty']['id'],
                'tytul'         => $debata['RadyKomisjePosiedzeniaDebaty']['tytul'],
                'video_start'   => $debata['RadyKomisjePosiedzeniaDebaty']['video_start'],
                'ord'           => $debata['RadyKomisjePosiedzeniaDebaty']['ord'],
                'mowcy'         => $mowcy
            );
        }

        return array(
            'posiedzenie' => $posiedzenie,
            'debaty' => $data
        );
    }

}