<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 15:02
 */
App::uses('CakeEmail', 'Network/Email');

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

    public function CleanUp()
    {
        $this->AnalyzerExecution->cleanUp();
    }

    public function MailAlerts()
    {
        $this->AnalyzerExecution->spaceCheck();

        $this->AnalyzerExecution->reportCheck();
    }

    public function CleanUpReports($days){
        $this->AnalyzerExecution->cleanUpReports($days);
    }
}