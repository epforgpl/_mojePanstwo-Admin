<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 01/06/15
 * Time: 14:43
 */

class WydaniaController extends MsigAppController
{

    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Msig.Wydania',
    'Msig.Dzialy',
        'PLText',
        'Paginator'
    );

    public function index()
    {
        $modes = array(
            'all' => 'Wszystkie',
            'error' => 'Błędne',
        );

        $mode = in_array(@$this->params['url']['mode'], array_keys($modes))
            ? $this->params['url']['mode'] : 'all';

        $this->set('modes', $modes);
        $this->set('mode', $mode);

        $conditions = array();
        $joins = array();
        $fields = array();
        if ($mode == 'error') {
            $conditions = array(
                'or' => array(
                    'Dzialy.strona_od' => '0',
                    'Dzialy.strona_do' => '0'
                )
            );
            $joins=array(
                array(
                    'alias' => 'Dzialy',
                    'table' => 'msig_dzialy',
                    'type' => 'INNER',
                    'conditions' => '`Dzialy`.`wydanie_id` = `Wydania`.`id`'
                )
            );
            $fields=array('Wydania.id', 'Wydania.nr','Wydania.rocznik', 'Wydania.data', 'Wydania.liczba_dzialow');

        }


        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Wydania' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                'conditions' => $conditions,
                'fields' => $fields,
                'joins' => $joins,
            )
        );

        $data = $this->Paginator->paginate('Wydania');
        $this->set('data', $data);

    }

    public function view($id)
    {
        $data = $this->Wydania->getData($id);
        if (!$data)
            throw new NotFoundException;

        if(
        ($doc = file_get_contents('https://mojepanstwo.pl/docs/' . $data['wydanie']['Wydania']['dokument_id'] . '.json')) &&
        ($doc = json_decode($doc, true))) {

            $this->set('doc', $doc);

        }

        $this->set('wydanie', $data['wydanie']);
        $this->set('dzialy', $data['dzialy']);
    }
}