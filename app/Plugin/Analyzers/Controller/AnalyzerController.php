<?php

class AnalyzerController extends AnalyzersAppController
{

    public $uses = array(
        'Analyzers.Analyzer',
        'Analyzers.AnalyzerExecution'
    );

    public $components = array(
        'RequestHandler'
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
        }

    }}