<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $uses = array(
        'Session'
    );

    public static $databaseTypes = array(
        'test' => 'Baza testowa',
        'prod' => 'Baza produkcyjna'
    );

    public static $databaseType = array();

    public function __construct() {
        parent::__construct();

        if(!count(self::$databaseType)) {
            App::uses('CakeSession', 'Model/Datasource');
            $type = in_array(CakeSession::read('Database.type'), array_keys(self::$databaseTypes)) ?
                CakeSession::read('Database.type') : array_keys(self::$databaseTypes)[1];

            self::$databaseType = array(
                'key' => $type,
                'value' => self::$databaseTypes[$type]
            );
        }

        $this->useDbConfig = self::$databaseType['key'];
    }

    /**
     * Menu
     *
     * @return array
     */
    public static function getMenu()
    {
        return array(
            'items' => array(
                array(
                    'label' => 'Dane',
                    'childrens' => array(
                        array(
                            'label' => 'Posiedzenia Rady Miasta',
                            'href' => '/krakow/rada_posiedzenia'
                        ),
                        array(
                            'label' => 'Dodawanie plików',
                            'href' => '/krakow/upload_sessions/addForm'
                        ),
                        array(
                            'label' => 'Zamowienia Publiczne',
                            'href' => '/zamowienia_publiczne/dokumenty'
                        ),
                        array(
                            'label' => 'Analizator',
                            'href' => '/analyzers'
                        )
                    )
                ),
                array(
                    'label' => 'Ustawienia',
                    'childrens' => array(
                        array(
                            'label' => 'Synchronizacja bazy',
                            'href' => '/settings/syncDatabase'
                        )
                    )
                )
            )
        );
    }

    /**
     * Tabele do kopiowania
     *
     * @return array
     */
    public static function getTables() {
        $names = array();
        $ends = array(
            'dzielnice',
            'dzielnice_rady_posiedzenia',
            'dzielnice_rady_posiedzenia_zalaczniki',
            'dzielnice_rady_uchwaly_przedzialy',
            //'glosowania',
            //'glosowania_glosy',
            'glosowania_pola',
            'jednostki',
            'oswiadczenia',
            'posiedzenia',
            'posiedzenia_punkty',
            //'posiedzenia_punkty_backup',
            //'posiedzenia_punkty_backup02',
            //'posiedzenia_punkty_backup03',
            'posiedzenia_punkty_plan',
            'posiedzenia_punkty_wystapienia',
            //'posiedzenia_punkty_wystapienia_backup01',
            'posiedzenia_punkty_portal',
            'posiedzenia_punkty_bip',
            'sesje',
            'urzednicy',
            'urzednicy-krs_osoby',
            //'zarzadzenia',
            //'zarzadzenia-zmiany',
            //'zarzadzenia_zalaczniki'
        );

        $prefix = 'pl_gminy_krakow_';
        foreach($ends as $table) {
            $names[] = $prefix . $table;
        }

        $names = array_merge($names, array(
            'krakow_upload_files',
            'krakow_upload_sessions',
            'rady_posiedzenia_pliki',
            'rady_posiedzenia_debaty_oznaczone_wystapienia',
            'rady_komisje',
            'rady_druki',
            'pl_dzielnice'
        ));

        $ends = array(
            'czesci',
            'czesci-wykonawcy',
            'dokumenty',
            'dokumenty-wykonawcy',
            'dokumenty_kryteria',
            'kryteria',
            'paczki',
            'rodzaje',
            'spolki_cywilne',
            'stats',
            'tryby',
            'typy',
            'wykonawcy',
            'zamawiajacy',
            'zamawiajacy_rodzaje',
            'zamowiena',
            'zamowienia_czesci',
            'zamowienia_czesci_kryteria'

        );

        $prefix = 'uzp_';
        foreach ($ends as $table) {
            $names[] = $prefix . $table;
        }

        return $names;
    }

}
