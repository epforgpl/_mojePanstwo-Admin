<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 19/06/15
 * Time: 12:58
 */

App::uses('AppModel', 'Model');

class PanelWskazniki extends WskaznikiAppModel {

    public $useTable='panel_wskazniki';

    public $hasAndBelongsToMany = array(
        'BdlPodgrupy' =>
            array(
                'className' => 'Wskazniki.BdlPodgrupy',
                'joinTable' => 'panel_wskazniki_BDL_podgrupy',
                'with' => 'Wskazniki.PanelWskaznikiBdlPodgrupy',
                'foreignKey' => 'panel_wskaznik_id',
                'associationForeignKey' => 'BDL_podgrupa_id',
                'fields' => 'tytul'
            )
    );
    public $actsAs = array('Containable');

}

