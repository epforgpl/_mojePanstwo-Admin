<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 28/05/15
 * Time: 10:42
 */

App::uses('AppModel', 'Model');

class Wydania extends AppModel
{

    public $useTable = 'msig_wydania';

    public function findByIdWithClosest($id)
    {
        $wydanie = $this->findById($id);
        if (!$wydanie)
            return false;

        $wydaniePrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Wydania.id <' => $wydanie['Wydania']['id']
            ),
            'order' => array(
                'Wydania.id' => 'desc'
            ),
        ));

        $wydanieNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Wydania.id >' => $wydanie['Wydania']['id']
            ),
            'order' => array(
                'Wydania.id' => 'asc'
            ),
        ));

        $wydanie['Wydania']['next'] = count($wydanieNext) > 0 ? $wydanieNext : false;
        $wydanie['Wydania']['prev'] = count($wydaniePrev) > 0 ? $wydaniePrev : false;

        return $wydanie;
    }

    public function getData($id)
    {
        $wydanie = $this->findByIdWithClosest($id);
        if (!$wydanie)
            return false;

        ClassRegistry::init('Msig.Dzialy');

        $Dzialy = new dzialy();

        $data = array();

        $dzialy = $Dzialy->find('all', array(
            'conditions' => array(
                'Dzialy.wydanie_id' => $id,
                'Dzialy.deleted NOT LIKE' => '1'
            ),
            'order' => array(
                'Dzialy.id'
            ),
        ));

        foreach ($dzialy as $dzial) {
            $data[] = array(
                'id' => $dzial['Dzialy']['id'],
                'nazwa' => $dzial['Dzialy']['nazwa'],
                'strona_od' => $dzial['Dzialy']['strona_od'],
                'strona_do' => $dzial['Dzialy']['strona_do'],
                'liczba_stron' => $dzial['Dzialy']['liczba_stron'],
            );
        }

        return array(
            'wydanie' => $wydanie,
            'dzialy' => $data
        );
    }
}
