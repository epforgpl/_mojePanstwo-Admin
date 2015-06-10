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
                'RadyKomisjePosiedzeniaDebaty.deleted NOT LIKE' => '1'
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
                    'RadyKomisjePosiedzeniaDebatyMowcy.deleted NOT LIKE' => '1'
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