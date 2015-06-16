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

        if (isset($this->params['url']['Tag'])) {
            $tag = $this->params['url']['Tag'];
        }
        if (isset($this->params['url']['search'])) {
            $search = $this->params['url']['search'];
        }

        ClassRegistry::init('Instytucje.Tagi');
        $tagi = new Tagi();
$conditions=array('Instytucje.deleted LIKE'=>'0');
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
                'order' => array('id' => 'asc'),
                'fields' => array('id', 'nazwa'),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'type'=>'LEFT',
                        'table' => 'instytucje-tagi',
                        'alias' => 'IT',
                        'conditions' => array('Instytucje.id = IT.instytucja_id')
                    ),
                    array(
                        'type'=>'LEFT',
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
            $this->Paginator->paginate('Instytucje');
        } catch (NotFoundException $e) {
            $this->redirect(array(
                'controller' => 'Instytucje',
                'action' => 'index',
                '?' => array(
                    'Tag' => $tag
                )));
        }

        $data = $this->Paginator->paginate('Instytucje');
        $this->set('data', $data);
        $this->set('tagi', $tagi);
    }

    public function view($id)
    {

        $data = $this->Instytucje->getData($id);
        if (!$data)
            throw new NotFoundException;

        $this->set('instytucja', $data['instytucja']);
    }

    public function add()
    {



    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_list=$_POST['delete_ids'];
            $this->Instytucje->updateAll(
                array('deleted' => "1"),
                array('id IN' => $id_list)
            );

            $this->json($id_list);
        } else {
            $this->json(false);
        }
        $this->autoRender = false;
    }

}