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
        'Bdl.Kategorie',
        'Bdl.Grupy',
        'Bdl.Podgrupy',
        'PLText',
        'Paginator'
    );

    public function index($id)
    {

        ClassRegistry::init('Bdl.Kategorie');
        ClassRegistry::init('Bdl.Grupy');

        $kategoria = new Kategorie();
        $grupa = new Grupy();

        $gru_id = $id;
        $grupa = $grupa->findByIdWithClosest($gru_id);

        $kat_id = $grupa['Grupy']['kat_id'];

        $kategoria = $kategoria->findByIdWithClosest($kat_id);

        $conditions = array('Podgrupy.grupa_id' => $id);
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
        $this->set('kategoria', $kategoria);
        $this->set('grupa', $grupa);
    }
    public function lista()
    {
        $conditions = array();
        $fields = array();

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Grupy' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                //'conditions' => $conditions,
                //'fields' => $fields,
            )
        );

        $data = $this->Paginator->paginate('Grupy');
        $this->set('data', $data);

    }
}