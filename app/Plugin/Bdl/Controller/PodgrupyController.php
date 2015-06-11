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

    public function index($cat = 'all', $grp = 'all')
    {
        if (isset($this->params['url']['Grupa'])) {
            $grp = $this->params['url']['Grupa'];
        }
        if (isset($this->params['url']['Kategoria'])) {
            $cat = $this->params['url']['Kategoria'];
        }

        ClassRegistry::init('Bdl.Grupy');
        ClassRegistry::init('Bdl.Kategorie');
        $kategoria = new Kategorie();
        $grupa = new Grupy();

        $conditions = array();
        if ($cat == 'all') {
            if ($grp == 'all') {

                $conditions = array('1');

                 $grupy = $grupa->find('list', array(
                       'fields' => array('Grupy.id', 'Grupy.tytul'),
                   ));
            } else {
                $conditions = array('Podgrupy.grupa_id' => $grp);

                $grupy = $grupa->find('list', array(
                    'fields' => array('Grupy.id', 'Grupy.tytul'),
                ));
            }
        } else {
            if ($grp == 'all') {
                $conditions = array('Podgrupy.kategoria_id' => $cat);
            } else {
                $conditions = array(
                    'Podgrupy.kategoria_id' => $cat,
                    'Podgrupy.grupa_id' => $grp
                );
            }
            $grupy = $grupa->find('list', array(
                'fields' => array('Grupy.id', 'Grupy.tytul'),
                'conditions' => array('Grupy.kat_id' => $cat)
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

        $kategorie = $kategoria->find('list', array(
            'fields' => array('Kategorie.id', 'Kategorie.tytul'),
        ));
        try {
            $this->Paginator->paginate('Podgrupy');
        } catch (NotFoundException $e) {
            $this->redirect(array(
                'controller' => 'Podgrupy',
                'action' => 'index',
                '?' => array(
                    'Kategoria' => $cat,
                    'Grupa' => $grp
                )));
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

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $opis = trim($_POST['opis']);
            $this->Podgrupy->id = $_POST['id'];
            $odp = $this->Podgrupy->saveField('opis', $opis);
            $this->json($odp);
        } else {
            $this->json(false);
        }
        $this->autoRender = false;
    }
}