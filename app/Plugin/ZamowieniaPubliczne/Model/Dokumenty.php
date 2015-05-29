<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 28/05/15
 * Time: 10:42
 */

App::uses('AppModel', 'Model');

class Dokumenty extends AppModel
{

    public $useTable = 'uzp_dokumenty';

    public function findByIdWithClosest($id)
    {
        $dokument = $this->findById($id);
        if (!$dokument)
            return false;

        $dokumentPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                    'Dokumenty.id <' => $dokument['Dokumenty']['id']
            ),
            'order' => array(
                'Dokumenty.id' => 'desc'
            ),
        ));

        $dokumentNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Dokumenty.id >' => $dokument['Dokumenty']['id']
            ),
            'order' => array(
                'Dokumenty.id' => 'asc'
            ),
        ));

        $dokument['Dokumenty']['next'] = count($dokumentNext) > 0 ? $dokumentNext : false;
        $dokument['Dokumenty']['prev'] = count($dokumentPrev) > 0 ? $dokumentPrev : false;

        return $dokument;
    }

    public function getData($id)
    {
        $dokument = $this->findByIdWithClosest($id);
        if (!$dokument)
            return false;

        ClassRegistry::init('ZamowieniaPubliczne.Czesci');

        $Czesci = new Czesci();

        $data = array();

        $czesci = $Czesci->find('all', array(
            'conditions' => array(
                'Czesci.dokument_id' => $id,
                'Czesci.deleted NOT LIKE' => '1'
            ),
            'order' => array(
                'Czesci.numer'
            ),
        ));

        foreach ($czesci as $czesc) {
            $data[] = array(
                'id' => $czesc['Czesci']['id'],
                'numer' => $czesc['Czesci']['numer'],
                'nazwa' => $czesc['Czesci']['nazwa'],
                'data_zam' => $czesc['Czesci']['data_zam'],
                'cena' => $czesc['Czesci']['cena'],
                'cena_min' => $czesc['Czesci']['cena_min'],
                'cena_max' => $czesc['Czesci']['cena_max'],
            );
        }

        return array(
            'dokument' => $dokument,
            'czesci' => $data
        );
    }
}

//id, numer, nazwa, data_zam, cena, cena_min, cena_max