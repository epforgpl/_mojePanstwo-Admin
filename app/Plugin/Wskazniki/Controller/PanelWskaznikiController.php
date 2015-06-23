<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 19/06/15
 * Time: 13:24
 */
class PanelWskaznikiController extends WskaznikiAppController
{
    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Wskazniki.BdlPodgrupy',
        'Wskazniki.PanelWskazniki',
        'Wskazniki.PanelWskaznikiBdlPodgrupy',
        'PLText',
        'Paginator'
    );

    public function index($search = 'all')
    {

        if (isset($this->params['url']['search'])) {
            $search = $this->params['url']['search'];
        }
        $conditions = array();

        if ($search !== 'all') {
            $conditions[] = "PanelWskazniki.nazwa LIKE '%$search%'";
        } else {
            $conditions[] = 1;
        }
        $conditions[] = "PanelWskazniki.deleted=0";

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'PanelWskazniki' => array(
                'limit' => 25,
                'order' => array('id' => 'asc'),
                'fields' => array('id', 'tytul'),
                'conditions' => $conditions,
            )
        );
        $this->PanelWskazniki->contain();
        // $this->PanelWskazniki->bindModel(array('hasOne'=>array('Wskazniki.PanelWskaznikiBdlPodgrupy')));

        try {
            $data = $this->Paginator->paginate('PanelWskazniki');
        } catch (NotFoundException $e) {
            $this->redirect(array(
                'controller' => 'PanelWskazniki',
                'action' => 'index',
            ));
        }
        $this->set('data', $data);
    }

    public function edit($id = '')
    {
        if ($id !== '') {
            $data = $this->PanelWskazniki->find('first', array('id' => $id));
            if (!$data)
                throw new NotFoundException;

            $this->set('wskazniki', $data['PanelWskazniki']);
            $this->set('podgrupy', $data['BdlPodgrupy']);
        }
    }

    public function add()
    {

    }

    public function getdata()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($_POST['search'] == '') {
                $conditions = 1;
            } else {
                $conditions = 'BdlPodgrupy.tytul LIKE "%' . $_POST['search'] . '%"';
            }

            $this->BdlPodgrupy->contain();
            if ($data = $this->BdlPodgrupy->find('all', array(
                    'conditions' => $conditions,
                    'fields' => array('tytul', 'id'),
                    'limit' => 14
                )
            )
            ) {
                $this->json($data);
            } else {
                $this->json(false);
            }
            $this->autoRender = false;
        }
    }
    public function savedata()
    {
        $this->json(true);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $wskaznik = array();
            $podgrupy = array();

            $i = 0;
            if (isset($_POST['licznik'])) {
                foreach ($_POST['licznik'] as $key => $val) {

                    $znak = str_replace('znak=', '', $val);
                    $podgrupy[] = array(
                        'BDL_podgrupa_id' => $key,
                        'L_M' => 'licznik',
                        'P_N' => $znak,
                        'position' => $i
                    );
                    $i++;
                }
            }
            $i = 0;
            if (isset($_POST['mianownik'])) {
                foreach ($_POST['mianownik'] as $key => $val) {

                    $znak = str_replace('znak=', '', $val);
                    $podgrupy[] = array(
                        'BDL_podgrupa_id' => $key,
                        'L_M' => 'mianownik',
                        'P_N' => $znak,
                        'position' => $i
                    );
                    $i++;
                }
            }

            if ($_POST['id'] !== '') {
                $wskaznik['PanelWskazniki']['id'] = $_POST['id'];
            }

            $wskaznik['BdlPodgrupy'] = array('BdlPodgrupy' => $podgrupy);
            $wskaznik['PanelWskazniki']['tytul'] = $_POST['tytul'];
            $wskaznik['PanelWskazniki']['opis'] = $_POST['opis'];

            if ($this->PanelWskazniki->save($wskaznik)) {
                $this->json($this->PanelWskazniki->getLastInsertId());
            } else {
                $this->json(false);
            }
        }
        $this->autoRender = false;
    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_list = $_POST['delete_ids'];
            if (sizeof($id_list) == 1) {
                $this->PanelWskazniki->updateAll(
                    array('deleted' => "1"),
                    array("id" => $id_list[0])
                );
            } else {
                $this->PanelWskazniki->updateAll(
                    array('deleted' => "1"),
                    array("id IN" => $id_list)
                );
            }

            $this->json($id_list);
        } else {
            $this->json(false);
        }
        $this->autoRender = false;
    }
}