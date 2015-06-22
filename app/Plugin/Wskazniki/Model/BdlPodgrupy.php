<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 19/06/15
 * Time: 12:57
 */

App::uses('AppModel', 'Model');

class BdlPodgrupy extends WskaznikiAppModel {

    public $useTable='BDL_podgrupy';

    public $hasAndBelongsToMany = array(
        'PanelWskazniki' =>
            array(
                'className' => 'Wskazniki.PanelWskazniki',
                'joinTable' => 'panel_wskazniki_BDL_podgrupy',
                'with' => 'Wskazniki.PanelWskaznikiBdlPodgrupy',
                'foreignKey' => 'BDL_podgrupa_id',
                'associationForeignKey' => 'panel_wskaznik_id',
            )
    );
    public $actsAs = array('Containable');
}