<?php

class AnalyzerController extends AnalyzersAppController
{

    public $uses = array(
        'Analyzers.Analyzer',
        'Analyzers.AnalyzerExecution',
        'Analyzers.PrawoLokalne',
        'Analyzers.PrawoUrzedowe',
    );

    public $components = array(
        'RequestHandler',
        'Paginator'
    );

    public function view()
    {

        $id = $this->request->params['named']['id'];

        $analyzer = $this->Analyzer->find('first', array(
            'conditions' => array(
                'Analyzer.id' => $id,
            ),
        ));

        $this->set('analyzer', $analyzer);

        $this->set('_serialize', array('analyzer'));

        switch ($id) {

            case 'Krs': {
                $this->render('view_krs');
                break;
            }
            case 'Prawo': {

                $modes = array(
                    'woj' => 'Wojewodztwa',
                    'gmi' => 'Gminy',
                    'inst' => 'Instytucje',
                    'err' => 'Błędne daty'
                );

                $mode = in_array(@$this->params['url']['mode'], array_keys($modes))
                    ? $this->params['url']['mode'] : 'woj';


                $this->set('modes', $modes);
                $this->set('mode', $mode);

                if ($mode == 'woj') {
                    $dict = $this->PrawoLokalne->getWoj();
                    $slow = array();
                    foreach ($dict as $key => $val) {
                        $slow += [$val['wojewodztwa']['id'] => $val['wojewodztwa']['nazwa']];
                    }
                    $dane = $this->PrawoLokalne->find('all', array(
                        'fields' => array('COUNT(*) as count', 'wojewodztwo_id', 'MAX(data_wydania) AS najnowsze'),
                        'group' => 'wojewodztwo_id',
                        'order' => 'najnowsze asc'
                    ));
                } elseif ($mode == 'gmi') {
                    $dict = $this->PrawoLokalne->getGmi();
                    $slow = array();
                    foreach ($dict as $key => $val) {
                        $slow += [$val['gminy']['id'] => $val['gminy']['nazwa']];
                    }
                    $slow += [0 => 'Nieprzypisane'];
                    $this->Paginator->settings = array(
                        'paramType' => 'querystring',
                        'PrawoLokalne' => array(
                            'limit' => 100,
                            'order' => 'najnowsze asc',
                            'fields' => array('COUNT(*) as count', 'gmina_id', 'MAX(data_wydania) AS najnowsze'),
                            'group' => 'gmina_id',
                        )
                    );

                    $dane = $this->Paginator->paginate('PrawoLokalne');

                } elseif ($mode == 'inst') {

                    $dict = $this->PrawoUrzedowe->getInst();
                    $slow = array();
                    foreach ($dict as $key => $val) {
                        $slow += [$val['instytucje']['id'] => $val['instytucje']['nazwa']];
                    }

                    $slow += [0 => 'Nieprzypisane'];
                    $this->Paginator->settings = array(
                        'paramType' => 'querystring',
                        'PrawoUrzedowe' => array(
                            'limit' => 100,
                            'order' => 'najnowsze asc',
                            'fields' => array('COUNT(*) as count', 'instytucja_id', 'MAX(data_wydania) AS najnowsze'),
                            'group' => 'instytucja_id',
                        )
                    );

                    $dane = $this->Paginator->paginate('PrawoUrzedowe');
                } else {

                    $this->Paginator->settings = array(
                        'paramType' => 'querystring',
                        'PrawoLokalne' => array(
                            'limit' => 25,
                            'fields' => array('id', 'tytul', 'rocznik', 'data_wydania'),
                            'conditions' => 'YEAR(data_wydania)>rocznik OR data_wydania > NOW()'
                        )
                    );
                    $dane = $this->Paginator->paginate('PrawoLokalne');
                    $slow = '';
                }
                $this->set('slownik', $slow);
                $this->set('dane', $dane);
                $this->render('view_prawo');
                break;
            }
            case 'Zamowienia Publiczne': {
                $this->render('view_zp');
                break;
            }
            case 'Indeksowanie': {
                $this->render('view_indeks');
                break;
            }
            case 'Cluster': {
                $this->render('view_cluster');
                break;
            }
            case 'BDL': {
                $this->render('view_bdl');
                break;
            }
        }

    }

    public function editPrawoLokalne($id)
    {
        $data = $this->PrawoLokalne->findById($id);
        $this->set('data', $data);
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $prawo = $this->PrawoLokalne->findById($_POST['id']);
            $prawo['PrawoLokalne']['rocznik'] = $_POST['rocznik'];
            $prawo['PrawoLokalne']['data_wydania'] = $_POST['data_wydania'];
            $prawo['PrawoLokalne']['organ_wydajacy_str'] = $_POST['organ_wydajacy_str'];
            if ($this->PrawoLokalne->save($prawo)) {
                $this->json($_POST['id']);
            } else {
                $this->json(false);
            }
            $this->autoRender = false;
        }
    }
}