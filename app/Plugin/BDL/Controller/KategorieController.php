<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:25
 */

class KategorieController extends BdlAppController {

    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'BDL.Kategorie',
        'BDL.Grupy',
        'BDL.Podgrupy',
        'PLText',
        'Paginator'
    );

    public function index()
    {

    }
}