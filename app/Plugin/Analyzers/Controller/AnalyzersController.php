<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 16:38
 */
class AnalyzersController extends AnalyzersAppController
{

    public $uses = array(
        'Analyzers.Analyzer',
        'Analyzers.AnalyzerExecution'
    );


    public function index()
    {
        $analyzers = $this->Analyzer->find('all', array(
            'fields' => array('id', 'execution_ts'),
        ));
        $this->set('analyzers', $analyzers);
    }
}
