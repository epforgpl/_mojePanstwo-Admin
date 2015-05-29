<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 29/05/15
 * Time: 13:08
 */

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
                $this->render('viewKrs');
            }
        }

    }}