<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 12:04
 */
class Analyzer extends AppModel
{

    public $useTable = 'analyzers';

    public $hasOne = array(
        'AnalyzerExecution' => array(
            'className' => 'AnalyzerExecution',
            'conditions' => array(
                'AnalyzerExecution.id = Analyzer.execution_id',
            ),
        ),
    );

    public $uses = array('AnalyzerExecution');

    public function execute($id)
    {

        $this->AnalyzerExecution->execute($id);

    }

    public function getLast()
    {

        $this->id = $this->Analyzer->find('first', array(
            'order' => array('Analyzers.execution_ts' => 'ASC')
        ));
        return $this->id;
    }

}