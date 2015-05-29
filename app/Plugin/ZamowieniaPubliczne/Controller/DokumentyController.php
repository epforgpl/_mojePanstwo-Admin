<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 28/05/15
 * Time: 10:40
 */
class DokumentyController extends ZamowieniaPubliczneAppController
{

    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'ZamowieniaPubliczne.Dokumenty',
        'PLText',
        'Paginator'
    );

    public function index()
    {
        $modes = array(
            'all' => 'Wszystkie',
            'error' => 'Błędne',
            'correct' => 'Poprawne'
        );

        $mode = in_array(@$this->params['url']['mode'], array_keys($modes))
            ? $this->params['url']['mode'] : 'all';

        $this->set('modes', $modes);
        $this->set('mode', $mode);

        $conditions = array();
        if ($mode == 'error')
            $conditions = array(
               'or' => array(
                    'Dokumenty.cena <' => 'Dokumenty.cena_min',
                    'and' => array(
                        'Dokumenty.cena_max !=' => '0',
                        'Dokumenty.cena > Dokumenty.cena_max',
                    )
                )
            );

        else if ($mode == 'correct')
            $conditions = array(
                'and' => array(
                    'cena >=' => 'cena_min',
                    'or' => array(
                        'cena <=' => 'cena_max',
                        'and' => array(
                            'cena >' => 'cena_max',
                            'cena_max =' => '0'
                        )
                    )
                ));

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'Dokumenty' => array(
                'limit' => 25,
                'order' => array('id' => 'desc'),
                'conditions' => $conditions,
            )
        );

        $data = $this->Paginator->paginate('Dokumenty');
        $this->set('data', $data);

    }

    public function view($id)
    {
        $data = $this->Dokumenty->getData($id);
        if (!$data)
            throw new NotFoundException;


        $czesci = json_encode($data['czesci']);//str_replace("'", "", json_encode($data['czesci']));
        $this->set('dokument', $data['dokument']);
        $this->set('czesci', $czesci);
    }
}