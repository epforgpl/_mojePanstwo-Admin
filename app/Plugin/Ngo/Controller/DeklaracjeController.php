<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 18/06/15
 * Time: 15:13
 */

class DeklaracjeController extends NgoAppController
{

    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Ngo.Deklaracje',
        'PLText',
        'Paginator'
    );

    public function index()
    {
        $modes = array(
            'req'=>'Oczekujące',
            'yes' => 'Przyjęte',
            'no' => 'Odrzucone',
        );

        $mode = in_array(@$this->params['url']['mode'], array_keys($modes))
            ? $this->params['url']['mode'] : 'req';

        $this->set('modes', $modes);
        $this->set('mode', $mode);

        $conditions = array();
        $joins = array();
        $fields = array();
        if ($mode == 'req') {
            $conditions = array('status'=>0);
        }elseif($mode =='yes'){
            $conditions = array('status'=>1);
        }elseif($mode =='no'){
            $conditions = array('status'=>2);
        }


        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Deklaracje' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                'conditions' => $conditions,
            )
        );

        $data = $this->Paginator->paginate('Deklaracje');
        $this->set('data', $data);

    }

    public function view($id)
    {
        $data = $this->Deklaracje->findByIdWithClosest($id);
        if (!$data)
            throw new NotFoundException;

        $this->set('deklaracja', $data);
    }
    
    public function save(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $deklaracja = $this->Deklaracje->findById($_POST['id']);
            $deklaracja['Deklaracje']['status'] = $_POST['status'];
            if ($this->Deklaracje->save($deklaracja)) {
                $this->json($_POST['status']);
            } else {
                $this->json(false);
            }
            $this->autoRender = false;
        }
    }
    
}