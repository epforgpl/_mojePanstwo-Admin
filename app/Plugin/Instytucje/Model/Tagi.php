<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 15/06/15
 * Time: 09:18
 */

class Tagi extends AppModel{

    public $useTable = 'instytucje_tagi';



    public $hasAndBelongsToMany = array(
        'Instytucje' =>
            array(
                'className' => 'Instytucje.Instytucje',
                'joinTable' => 'instytucje-tagi',
                'foreignKey' => 'tag_id',
                'associationForeignKey' => 'instytucja_id'
            )
    );
    public $actsAs = array('Containable');
}