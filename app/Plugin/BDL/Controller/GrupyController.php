<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 16:02
 */

class GrupyController extends BdlAppController {

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