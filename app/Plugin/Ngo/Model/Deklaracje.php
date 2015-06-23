<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 18/06/15
 * Time: 15:13
 */

class Deklaracje extends NgoAppModel{

    public $useTable = 'ngo_declarations';

    public function findByIdWithClosest($id)
    {
        $deklaracja = $this->findById($id);
        if (!$deklaracja)
            return false;

        $deklaracjaPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Deklaracje.id <' => $deklaracja['Deklaracje']['id'],
                'status'=>0
            ),
            'order' => array(
                'Deklaracje.id' => 'desc'
            ),
        ));

        $deklaracjaNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Deklaracje.id >' => $deklaracja['Deklaracje']['id'],
                'status'=>0
            ),
            'order' => array(
                'Deklaracje.id' => 'asc'
            ),
        ));

        $deklaracja['Deklaracje']['next'] = count($deklaracjaNext) > 0 ? $deklaracjaNext : false;
        $deklaracja['Deklaracje']['prev'] = count($deklaracjaPrev) > 0 ? $deklaracjaPrev : false;

        return $deklaracja;
    }

}