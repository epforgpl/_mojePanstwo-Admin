<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:25
 */
class KategorieController extends BdlAppController
{

    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Bdl.Kategorie',
        'Bdl.Grupy',
        'Bdl.Podgrupy',
        'PLText',
        'Paginator'
    );

    public function index($id)
    {
        ClassRegistry::init('Bdl.Kategorie');

        $kategoria = new Kategorie();
        $kategoria = $kategoria->findByIdWithClosest($id);

        $this->set('kategoria', $kategoria);


        $conditions = array('Podgrupy.kategoria_id' => $id);
        $fields = array();

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Podgrupy' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                'conditions' => $conditions,
                //'fields' => $fields,
            )
        );

        $data = $this->Paginator->paginate('Podgrupy');
        $this->set('data', $data);
    }

    public function lista()
    {
        $conditions = array();
        $fields = array();

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Kategorie' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                //'conditions' => $conditions,
                //'fields' => $fields,
            )
        );

        $data = $this->Paginator->paginate('Kategorie');
        $this->set('data', $data);

    }
}