<?php

App::uses('AppModel', 'Model');

class RadyDzielnicePosiedzenia extends AppModel {

    public $useTable = 'rady_dzielnice_posiedzenia';

    public function findByIdWithClosest($id) {
        $posiedzenie = $this->findById($id);
        if(!$posiedzenie)
            return false;

        $posiedzenieNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'RadyDzielnicePosiedzenia.date >' => $posiedzenie['RadyDzielnicePosiedzenia']['date']
            ),
            'order' => array(
                'RadyDzielnicePosiedzenia.date' => 'asc'
            ),
        ));

        $posiedzeniePrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'RadyDzielnicePosiedzenia.date <' => $posiedzenie['RadyDzielnicePosiedzenia']['date']
            ),
            'order' => array(
                'RadyDzielnicePosiedzenia.date' => 'desc'
            ),
        ));

        $posiedzenie['RadyDzielnicePosiedzenia']['next'] = count($posiedzenieNext) > 0 ? $posiedzenieNext : false;
        $posiedzenie['RadyDzielnicePosiedzenia']['prev'] = count($posiedzeniePrev) > 0 ? $posiedzeniePrev : false;

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

            ClassRegistry::init('Krakow.RadyDzielnicePosiedzeniaPunkty');
            ClassRegistry::init('Krakow.RadyDzielnicePosiedzeniaPunktyMowcy');

            $Punkty = new RadyDzielnicePosiedzeniaPunkty();
            $Mowcy = new RadyDzielnicePosiedzeniaPunktyMowcy();

            $dodanePunkty = array();

            foreach($data as $punkt) {

                $punkt_id = 0;
                if(strpos($punkt['id'], '_') === false) {
                    $punkt_id = $punkt['id'];
                    $Punkty->clear();
                    $Punkty->id = $punkt_id;
                    $Punkty->save(array(
                        'tytul' => $punkt['tytul'],
                        'video_start' => $punkt['video_start'],
                        'posiedzenie_id' => $posiedzenie_id,
                        'ord' => $punkt['ord']
                    ));
                } else {
                    $Punkty->clear();
                    $Punkty->save(array(
                        'tytul' => $punkt['tytul'],
                        'video_start' => $punkt['video_start'],
                        'posiedzenie_id' => $posiedzenie_id,
                        'ord' => $punkt['ord']
                    ));
                    $punkt_id = $Punkty->getInsertID();
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

            $Punkty->clear();
            $Punkty->updateAll(
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

        ClassRegistry::init('Krakow.RadyDzielnicePosiedzeniaPunkty');
        ClassRegistry::init('Krakow.RadyDzielnicePosiedzeniaPunktyMowcy');

        $Punkty = new RadyDzielnicePosiedzeniaPunkty();
        $Mowcy = new RadyDzielnicePosiedzeniaPunktyMowcy();

        $data = array();

        $debaty = $Punkty->find('all', array(
            'conditions' => array(
                'RadyDzielnicePosiedzeniaPunkty.posiedzenie_id' => $id,
                'RadyDzielnicePosiedzeniaPunkty.deleted LIKE' => '0'
            ),
            'order' => array(
                'RadyDzielnicePosiedzeniaPunkty.ord'
            ),
        ));

        $data = array();

        foreach($debaty as $debata) {
            $mowcy = array();
            $mowcySrc = $Mowcy->find('all', array(
                    'conditions' => array(
                        'RadyDzielnicePosiedzeniaPunktyMowcy.punkt_id' => $debata['RadyDzielnicePosiedzeniaPunkty']['id'],
                        'RadyDzielnicePosiedzeniaPunktyMowcy.deleted LIKE' => '0'
                    ))
            );

            foreach($mowcySrc as $row) {
                $mowcy[] = array(
                    'id'            => $row['RadyDzielnicePosiedzeniaPunktyMowcy']['osoba_id'],
                    'ord'           => $row['RadyDzielnicePosiedzeniaPunktyMowcy']['ord'],
                    'nazwa'         => $row['RadyDzielnicePosiedzeniaPunktyMowcy']['nazwa']
                );
            }

            $data[] = array(
                'id'            => $debata['RadyDzielnicePosiedzeniaPunkty']['id'],
                'tytul'         => $debata['RadyDzielnicePosiedzeniaPunkty']['tytul'],
                'video_start'   => $debata['RadyDzielnicePosiedzeniaPunkty']['video_start'],
                'ord'           => $debata['RadyDzielnicePosiedzeniaPunkty']['ord'],
                'mowcy'         => $mowcy
            );
        }

        return array(
            'posiedzenie' => $posiedzenie,
            'debaty' => $data
        );
    }


}