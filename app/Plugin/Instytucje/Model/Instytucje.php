<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 15/06/15
 * Time: 09:18
 */

App::uses('AppModel', 'Model');

class Instytucje extends AppModel
{

    public $useTable = 'instytucje';


    public $hasAndBelongsToMany = array(
        'Tagi' =>
            array(
                'className' => 'Instytucje.Tagi',
                'joinTable' => 'instytucje-tagi',
                'foreignKey' => 'instytucja_id',
                'associationForeignKey' => 'tag_id'
            )
    );
    public $actsAs = array('Containable');

    public function findByIdWithClosest($id)
    {
        $instytucja = $this->findById($id);
        if (!$instytucja)
            return false;

        $instytucjaPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Instytucje.id <' => $instytucja['Instytucje']['id']
            ),
            'order' => array(
                'Instytucje.id' => 'desc'
            ),
        ));

        $instytucjaNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Instytucje.id >' => $instytucja['Instytucje']['id']
            ),
            'order' => array(
                'Instytucje.id' => 'asc'
            ),
        ));

        $instytucja['Instytucje']['next'] = count($instytucjaNext) > 0 ? $instytucjaNext : false;
        $instytucja['Instytucje']['prev'] = count($instytucjaPrev) > 0 ? $instytucjaPrev : false;

        return $instytucja;
    }
    public function getData($id)
    {
        $instytucja = $this->findByIdWithClosest($id);
        if (!$instytucja)
            return false;

        return array(
            'instytucja' => $instytucja,
        );
    }
}