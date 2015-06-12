<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:06
 */
class Podgrupy extends AppModel
{

    public $useTable = 'BDL_podgrupy';

    public function findByIdWithClosest($id)
    {
        $podgrupa = $this->findById($id);
        if (!$podgrupa)
            return false;

        $podgrupaPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Podgrupy.id <' => $podgrupa['Podgrupy']['id']
            ),
            'order' => array(
                'Podgrupy.id' => 'desc'
            ),
        ));

        $podgrupaNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Podgrupy.id >' => $podgrupa['Podgrupy']['id']
            ),
            'order' => array(
                'Podgrupy.id' => 'asc'
            ),
        ));

        $podgrupa['Podgrupy']['next'] = count($podgrupaNext) > 0 ? $podgrupaNext : false;
        $podgrupa['Podgrupy']['prev'] = count($podgrupaPrev) > 0 ? $podgrupaPrev : false;

        return $podgrupa;
    }

    public function getData($id)
    {
        $podgrupa = $this->findByIdWithClosest($id);
        if (!$podgrupa)
            return false;

        ClassRegistry::init('Bdl.Kategorie');
        ClassRegistry::init('Bdl.Grupy');

        $kategoria = new Kategorie();
        $grupa = new Grupy();

        $gru_id = $podgrupa['Podgrupy']['grupa_id'];
        $kat_id = $podgrupa['Podgrupy']['kategoria_id'];
        $grupa = $grupa->findByIdWithClosest($gru_id);
        $kategoria = $kategoria->findByIdWithClosest($kat_id);
        return array(
            'podgrupa' => $podgrupa,
            'kategoria' => $kategoria,
            'grupa' => $grupa,
        );
    }
}