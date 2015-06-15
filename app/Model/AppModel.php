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
class AppModel extends Model
{
public $useTable='instytucje-tagi';

    public $uses = array(
        'Session'
    );

    public static $databaseTypes = array(
        'test' => 'Baza testowa',
        'prod' => 'Baza produkcyjna'
    );

    public static $databaseType = array();

    /**
     * Przywileje użytkowników
     *
     * @var array
     */
    private static $privilegesRules = array(
        array(
            'groups' => '*',
            'plugin' => 'opauth',
            'controller' => '*',
            'action' => '*'
        ),
        array(
            'groups' => '*',
            'plugin' => '',
            'controller' => array('users', 'pages', 'settings', 'amazon'),
            'action' => '*'
        ),
        array(
            'groups' => array('admin'),
            'plugin' => '*',
            'controller' => '*',
            'action' => '*'
        ),
        array(
            'groups' => array('pk-admin'),
            'plugin' => array('krs', 'krakow'),
            'controller' => '*',
            'action' => '*'
        ),
        array(
            'groups' => array('pk-rada'),
            'plugin' => array('krakow'),
            'controller' => '*',
            'action' => '*'
        ),
        array(
            'groups' => array('pk-rada', 'pk-dzielnica6', 'pk-dzielnica14'),
            'plugin' => array('krakow'),
            'controller' => 'upload_sessions',
            'action' => '*'
        ),
    );

    public function __construct()
    {
        parent::__construct();

        if (!count(self::$databaseType)) {
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

    private static function accessPluginValidation($request, $rules)
    {
        $plugin = strtolower(trim($request['plugin']));
        if ($rules['plugin'] == '*')
            return true;
        if (is_array($rules['plugin']) && in_array($plugin, $rules['plugin']))
            return true;
        if (!is_array($rules['plugin']) && $rules['plugin'] == $plugin)
            return true;
        return false;
    }

    private static function accessControllerValidation($request, $rules)
    {
        $controller = strtolower(trim($request['controller']));
        if ($rules['controller'] == '*')
            return true;
        if (is_array($rules['controller']) && in_array($controller, $rules['controller']))
            return true;
        if (!is_array($rules['controller']) && $rules['controller'] == $controller)
            return true;
        return false;
    }

    private static function accessActionValidation($request, $rules)
    {
        $action = strtolower(trim($request['action']));
        if ($rules['action'] == '*')
            return true;
        if (is_array($rules['action']) && in_array($action, $rules['action']))
            return true;
        if (!is_array($rules['action']) && $rules['action'] == $action)
            return true;
        return false;
    }

    private static function accessGroupValidation($user, $rules)
    {
        $groups = $rules['groups'];
        if (!is_array($groups) && $groups == '*')
            return true;

        if ($user) {
            if (!isset($user['admin_groups']) || count($user['admin_groups']) == 0)
                return false;

            if (!is_array($groups) && in_array(strtolower(trim($groups)), $user['admin_groups']))
                return true;

            if (is_array($groups)) {
                foreach ($groups as $group) {
                    if (in_array(strtolower(trim($group)), $user['admin_groups']))
                        return true;
                }
            }
        }

        return false;
    }

    public static function checkAccess($request, $user)
    {
        $allow = false;
        foreach (self::$privilegesRules as $rules) {
            if (self::accessPluginValidation($request, $rules)) {
                if (self::accessControllerValidation($request, $rules)) {
                    if (self::accessActionValidation($request, $rules)) {
                        if (self::accessGroupValidation($user, $rules)) {
                            $allow = true;
                        }
                    }
                }
            }
        }

        return $allow;
    }

    /**
     * Menu
     *
     * @return array
     */
    public static function getMenu($user)
    {
        $menu = array(
            'items' => array(
                array(
                    'label' => 'Dane',
                    'childrens' => array(
                        array(
                            'label' => 'Posiedzenia Rady Miasta',
                            'href' => '/krakow/rada_posiedzenia',
                            'groups' => array('admin', 'pk-admin', 'pk-rada')
                        ),
                        array(
                            'label' => 'Punkty posiedzenia Rady Miasta',
                            'href' => '/krakow/rada_posiedzenia_punkty_sesja',
                            'groups' => array('admin', 'pk-admin', 'pk-rada')
                        ),
                        array(
                            'label' => 'Sesje',
                            'href' => '/krakow/upload_sessions',
                            'groups' => array('admin', 'pk-admin', 'pk-rada', 'pk-dzielnica6', 'pk-dzielnica14')
                        ),
                        array(
                            'label' => 'Posiedzenia Dzielnice',
                            'href' => '/krakow/posiedzenia_dzielnice',
                            'groups' => array('admin', 'pk-admin', 'pk-rada')
                        ),
                        array(
                            'label' => 'Posiedzenia Komisje',
                            'href' => '/krakow/posiedzenia_komisje',
                            'groups' => array('admin', 'pk-admin', 'pk-rada')
                        ),
                        array(
                            'label' => 'Zamowienia Publiczne',
                            'href' => '/zamowienia_publiczne/dokumenty',
                            'groups' => array('admin')
                        ),
                        array(
                            'label' => 'MSiG',
                            'href' => '/msig/wydania',
                            'groups' => array('admin')
                        ),
                        array(
                            'label' => 'Analizator',
                            'href' => '/analyzers',
                            'groups' => array('admin')
                        ),
                        array(
                            'label' => 'BDL',
                            'href' => '/bdl/podgrupy',
                            'groups' => array('admin')
                        ),
                        array(
                            'label' => 'Instytucje',
                            'href' => '/instytucje',
                            'groups' => array('admin')
                        )
                    )
                ),
                array(
                    'label' => 'Ustawienia',
                    'childrens' => array(
                        array(
                            'label' => 'Synchronizacja bazy',
                            'href' => '/settings/syncDatabase',
                            'groups' => array('admin')
                        )
                    )
                )
            )
        );

        if (!$user)
            return array();

        if (!isset($user['admin_groups']) || count($user['admin_groups']) == 0)
            return array();

        $groups = $user['admin_groups'];
        foreach ($menu['items'] as $i => $item) {
            if (isset($item['childrens']) && is_array($item['childrens'])) {
                foreach ($item['childrens'] as $c => $child) {
                    if (isset($child['groups'])) {
                        $enabled = false;
                        foreach ($groups as $group) {
                            if (in_array($group, $child['groups'])) {
                                $enabled = true;
                                break;
                            }
                        }

                        if (!$enabled) {
                            unset($menu['items'][$i]['childrens'][$c]);
                        }
                    }
                }
            }
        }

        return $menu;
    }

    /**
     * Tabele do kopiowania
     *
     * @return array
     */
    public static function getTables()
    {
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
        foreach ($ends as $table) {
            $names[] = $prefix . $table;
        }

        $names = array_merge($names, array(
            'krakow_upload_files',
            'krakow_upload_sessions',
            'rady_posiedzenia_pliki',
            'rady_posiedzenia_debaty_oznaczone_wystapienia',
            'rady_komisje',
            'rady_komisje_posiedzenia',
            'rady_komisje_posiedzenia_debaty',
            'rady_komisje_posiedzenia_debaty_mowcy',
            'rady_dzielnice_posiedzenia',
            'rady_dzielnice_posiedzenia_punkty',
            'rady_dzielnice_posiedzenia_punkty_mowcy',
            'rady_druki',
            'pl_dzielnice',
            'rady_posiedzenia_osoby'
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
