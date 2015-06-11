<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 10/06/15
 * Time: 14:58
 */
class PodgrupyController extends BdlAppController
{


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
        ClassRegistry::init('Bdl.Grupy');
        ClassRegistry::init('Bdl.Kategorie');
        $kategorie = new Kategorie();
        $grupy = new Grupy();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //debug($_POST);
            $conditions=array();
            if ($_POST['Kategoria'] == 'all') {
                if ($_POST['Grupa'] == 'all') {

                    $conditions=array('1');

                    $kategorie = $kategorie->find('list', array(
                        'fields' => array('Kategorie.id', 'Kategorie.tytul'),
                    ));

                    $grupy = $grupy->find('list', array(
                        'fields' => array('Grupy.id', 'Grupy.tytul'),
                    ));
                }else{
                    $conditions=array('Podgrupy.grupa_id'=>$_POST['Grupa']);

                    $grupy = $grupy->find('list', array(
                        'fields' => array('Grupy.id', 'Grupy.tytul'),
                        'conditions' => array('Grupy.id' => $_POST['Grupa'])
                    ));
                    $kategorie = $kategorie->find('list', array(
                        'fields' => array('Kategorie.id', 'Kategorie.tytul'),
                        'conditions' => array('Kategorie.id' => array_keys($grupy)[0])
                    ));
                }
            }else{

                $conditions=array('Podgrupy.grupa_id'=>$_POST['Kategoria']);

                $grupy = $grupy->find('list', array(
                    'fields' => array('Grupy.id', 'Grupy.tytul'),
                    'conditions' => array('Grupy.kat_id' => $_POST['Kategoria'])
                ));

                $kategorie = $kategorie->find('list', array(
                    'fields' => array('Kategorie.id', 'Kategorie.tytul'),
                    'conditions' => array('Kategorie.id' => $_POST['Kategoria'])
                ));
            }

            $this->Paginator->settings = array(
                'paramType' => 'querystring',
                'Podgrupy' => array(
                    'limit' => 25,
                    'order' => array('id' => 'desc'),
                    'conditions' => $conditions
                )
            );

        } else {
            $this->Paginator->settings = array(
                'paramType' => 'querystring',
                'Podgrupy' => array(
                    'limit' => 25,
                    'order' => array('id' => 'desc'),
                )
            );

            $kategorie = $kategorie->find('list', array(
                'fields' => array('Kategorie.id', 'Kategorie.tytul'),
            ));

            $grupy = $grupy->find('list', array(
                'fields' => array('Grupy.id', 'Grupy.tytul'),
            ));
        }
        $data = $this->Paginator->paginate('Podgrupy');
        $this->set('data', $data);
        $this->set('kategorie', $kategorie);
        $this->set('grupy', $grupy);
    }

    public function view($id)
    {
        $data = $this->Podgrupy->getData($id);
        if (!$data)
            throw new NotFoundException;

        $this->set('podgrupa', $data['podgrupa']);
        $this->set('kategoria', $data['kategoria']);
        $this->set('grupa', $data['grupa']);
    }

    public function update(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->Podgrupy->id = $_POST['id'];

            debug($_POST);
        }

        $this->autoRender = false;
        //$this->json('AAAAAAAAA');
    }
}