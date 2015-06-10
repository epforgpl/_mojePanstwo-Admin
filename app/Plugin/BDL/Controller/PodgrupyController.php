<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:58
 */

class PodgrupyController extends BdlAppController {


    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Bdl.Podgrupy',
        'Bdl.Grupy',
        'Bdl.Kategorie',
        'PLText',
        'Paginator'
    );

    public function index()
    {


        $conditions = array();
        $fields = array();

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Podgrupy' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                //'conditions' => $conditions,
                //'fields' => $fields,
            )
        );

        $data = $this->Paginator->paginate('Podgrupy');
        $this->set('data', $data);
    }

    public function view($id){
        $data = $this->Podgrupy->getData($id);
        if (!$data)
            throw new NotFoundException;

        $this->set('podgrupa', $data['podgrupa']);
        $this->set('kategoria', $data['kategoria']);
        $this->set('grupa',$data['grupa']);
    }
}