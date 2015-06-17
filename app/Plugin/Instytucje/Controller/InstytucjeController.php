<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 15/06/15
 * Time: 09:17
 */
class InstytucjeController extends InstytucjeAppController
{
    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Instytucje.Instytucje',
        'Instytucje.Tagi',
        'PLText',
        'Paginator'
    );

    public function index($tag = 'all', $search = 'all')
    {
        $modes = array(
            'act' => 'Aktualne',
            'del' => 'Usunięte',
        );

        $mode = in_array(@$this->params['url']['mode'], array_keys($modes))
            ? $this->params['url']['mode'] : 'act';

        $this->set('modes', $modes);
        $this->set('mode', $mode);


        if (isset($this->params['url']['Tag'])) {
            $tag = $this->params['url']['Tag'];
        }
        if (isset($this->params['url']['search'])) {
            $search = $this->params['url']['search'];
        }

        ClassRegistry::init('Instytucje.Tagi');
        $tagi = new Tagi();
        if ($mode == 'del') {
            $conditions = array('Instytucje.deleted LIKE' => '1');
        } else {
            $conditions = array('Instytucje.deleted LIKE' => '0');
        }
        if ($tag !== 'all') {
            $conditions[] = array('tag_id' => $tag);
        }
        if ($search !== 'all') {
            $conditions[] = "Instytucje.nazwa LIKE '%$search%'";
        }

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Instytucje' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                'fields' => array('DISTINCT id', 'nazwa'),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'type' => 'LEFT',
                        'table' => 'instytucje-tagi',
                        'alias' => 'IT',
                        'conditions' => array('Instytucje.id = IT.instytucja_id')
                    ),
                    array(
                        'type' => 'LEFT',
                        'table' => 'instytucje_tagi',
                        'alias' => 'Tagi',
                        'conditions' => array('Tagi.id = IT.tag_id')
                    )
                ),

            )
        );

        $tagi = $tagi->find('list', array(
            'fields' => array('Tagi.id', 'Tagi.nazwa'),
        ));
        try {
            $data = $this->Paginator->paginate('Instytucje');
        } catch (NotFoundException $e) {
            $this->redirect(array(
                'controller' => 'Instytucje',
                'action' => 'index',
                '?' => array(
                    'Tag' => $tag
                )));
        }
        $this->set('data', $data);
        $this->set('tagi', $tagi);
    }

    public function view($id = '')
    {
        if ($id !== '') {
            $data = $this->Instytucje->getData($id);
            if (!$data)
                throw new NotFoundException;
            $this->Tagi->contain();
            $tags = $this->Tagi->find('list', array(
                'fields' => array('Tagi.id', 'Tagi.nazwa'),
            ));

            $this->set('instytucja', $data['instytucja']);
            $this->set('tags', $tags);
        }
    }

    public function add()
    {
        $this->Tagi->contain();
        $tags = $this->Tagi->find('list', array(
            'fields' => array('Tagi.id', 'Tagi.nazwa'),
        ));

        $this->set('tags', $tags);

    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $gender = str_replace('gender=', '', $_POST['gender']);
            $instytucja = $this->Instytucje->findById($_POST['id']);
            $tagi = str_replace('tagi=', '', $_POST['tagi']);
            $tagi = explode('&', $tagi);
            $instytucja['Tagi'] = array('Tagi' => $tagi);
            $instytucja['Instytucje']['gender'] = $gender;
            $instytucja['Instytucje']['phone'] = $_POST['phone'];
            $instytucja['Instytucje']['email'] = $_POST['email'];
            $instytucja['Instytucje']['nazwa'] = $_POST['nazwa'];
            $instytucja['Instytucje']['adres_str'] = $_POST['adres_str'];
            $instytucja['Instytucje']['fax'] = $_POST['fax'];
            $instytucja['Instytucje']['www'] = $_POST['www'];
            preg_match('/[0-9]{2}-[0-9]{3}/', $_POST['adres_str'], $match);
            $instytucja['Instytucje']['kod_pocztowy_str'] = $match[0];
            $instytucja['Instytucje']['opis_html'] = $_POST['opis_html'];
            $instytucja['Instytucje']['modified'] = date('Y-m-d H:i:s', time());
            if ($this->Instytucje->save($instytucja)) {
                $this->json($_POST['id']);
            } else {
                $this->json(false);
            }
            $this->autoRender = false;
        }
    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_list = $_POST['delete_ids'];
            if (sizeof($id_list) == 1) {
                $this->Instytucje->updateAll(
                    array('deleted' => "1"),
                    array("id" => $id_list[0])
                );
            } else {
                $this->Instytucje->updateAll(
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

    public function undelete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_list = $_POST['delete_ids'];
            if (sizeof($id_list) == 1) {
                $this->Instytucje->updateAll(
                    array('deleted' => "0"),
                    array("id" => $id_list[0])
                );
            } else {
                $this->Instytucje->updateAll(
                    array('deleted' => "0"),
                    array("id IN" => $id_list)
                );
            }

            $this->json($id_list);
        } else {
            $this->json(false);
        }
        $this->autoRender = false;
    }

    public function addnew()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $gender = str_replace('gender=', '', $_POST['gender']);
            $instytucja = array();
            $tagi = str_replace('tagi=', '', $_POST['tagi']);
            $tagi = explode('&', $tagi);
            $instytucja['Tagi'] = array('Tagi' => $tagi);
            $instytucja['Instytucje']['gender'] = $gender;
            $instytucja['Instytucje']['phone'] = $_POST['phone'];
            $instytucja['Instytucje']['email'] = $_POST['email'];
            $instytucja['Instytucje']['nazwa'] = $_POST['nazwa'];
            $instytucja['Instytucje']['adres_str'] = $_POST['adres_str'];
            $instytucja['Instytucje']['fax'] = $_POST['fax'];
            $instytucja['Instytucje']['www'] = $_POST['www'];
            preg_match('/[0-9]{2}-[0-9]{3}/', $_POST['adres_str'], $match);
            if(isset($match[0])) {
                $instytucja['Instytucje']['kod_pocztowy_str'] = $match[0];
            }
            $instytucja['Instytucje']['opis_html'] = $_POST['opis_html'];
            $instytucja['Instytucje']['created'] = date('Y-m-d H:i:s', time());


            if ($this->Instytucje->save($instytucja)) {
                $this->json(true);
            } else {
                $this->json(false);
            }
            $this->autoRender = false;
        }
    }

}