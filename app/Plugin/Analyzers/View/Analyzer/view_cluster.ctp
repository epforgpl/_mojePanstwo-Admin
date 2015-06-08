<?php
echo $this->Html->script('Analyzers.highcharts');
echo $this->Html->script('Analyzers.highcharts-more');
echo $this->Html->script('Analyzers.timeago');
echo $this->Html->script('Analyzers.refresherCluster');
echo $this->Html->css('Analyzers./Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);
$temp = array();
foreach ($data as $key => $val) {
    if (!isset($temp[$key])) {
        if ($key !== '') {
            echo "<div class='row'><div class='col-sm-12'><hr></div><div class='col-sm-6'><div id='".$key."_la'></div></div>";
            echo "<div class='col-sm-6'><div id='{$key}_fs'></div></div></div>";
        }
    }
    $temp[$key] = $key;
}
?>