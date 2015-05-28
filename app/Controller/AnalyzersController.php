<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 16:38
 */
class AnalyzersController extends AppController
{

    public function index()
    {
        $analyzers = $this->Analyzer->find('all', array(
            'fields' => array('id', 'execution_ts'),
        ));
        $this->set('analyzers', $analyzers);
    }

    public function view()
    {

        $id = $this->request->params['named']['id'];

        $analyzer = $this->Analyzer->find('first', array(
            'conditions' => array(
                'Analyzer.id' => $id,
            ),
        ));

        $this->set('analyzer', $analyzer);

        switch ($id) {

            case 'Krs': {
                $this->render('viewKrs');
            }
        }

    }
}
