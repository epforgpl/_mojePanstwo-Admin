<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:10
 */

class Grupy extends AppModel{

    public $useTable = 'BDL_grupy';

    public function findByIdWithClosest($id)
    {
        $grupa = $this->findById($id);
        if (!$grupa)
            return false;

        $grupaPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Grupy.id <' => $grupa['Grupy']['id']
            ),
            'order' => array(
                'Grupy.id' => 'desc'
            ),
        ));

        $grupaNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Grupy.id >' => $grupa['Grupy']['id']
            ),
            'order' => array(
                'Grupy.id' => 'asc'
            ),
        ));

        $grupa['Grupy']['next'] = count($grupaNext) > 0 ? $grupaNext : false;
        $grupa['Grupy']['prev'] = count($grupaPrev) > 0 ? $grupaPrev : false;

        return $grupa;
    }
}