<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 15:02
 */
class AnalyzerShell extends Shell
{
    public $uses = array('Analyzers.Analyzer', 'Analyzers.AnalyzerExecution');

    public function ExecutionLoop()
    {

        while (1) {
            $analyzer = $this->Analyzer->find('first', array(
                'order' => array('execution_ts' => 'ASC')
            ));

            $this->AnalyzerExecution->executeSave($analyzer['Analyzer']['id']);
            sleep(15);
        }
    }

    public function cleanUp()
    {
        $this->AnalyzerExecution->cleanUp();
    }

}