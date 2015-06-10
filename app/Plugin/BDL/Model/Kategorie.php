<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:10
 */

class Kategorie extends AppModel{

    public $useTable = 'BDL_kategorie';

    public function findByIdWithClosest($id)
    {
        $kategoria = $this->findById($id);
        if (!$kategoria)
            return false;

        $kategoriaPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Kategorie.id <' => $kategoria['Kategorie']['id']
            ),
            'order' => array(
                'Kategorie.id' => 'desc'
            ),
        ));

        $kategoriaNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Kategorie.id >' => $kategoria['Kategorie']['id']
            ),
            'order' => array(
                'Kategorie.id' => 'asc'
            ),
        ));

        $kategoria['Kategorie']['next'] = count($kategoriaNext) > 0 ? $kategoriaNext : false;
        $kategoria['Kategorie']['prev'] = count($kategoriaPrev) > 0 ? $kategoriaPrev : false;

        return $kategoria;
    }
}