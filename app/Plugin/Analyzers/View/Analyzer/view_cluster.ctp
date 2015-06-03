<?php
echo $this->Html->script('Analyzers.highcharts');
echo $this->Html->script('Analyzers.highcharts-more');
echo $this->Html->script('Analyzers.timeago');
echo $this->Html->script('Analyzers.refresherCluster');
echo $this->Html->css('Analyzers./Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);
debug($data);
?>
<div id="container"></div>


<?php

$temp = array();
foreach ($data['cluster'] as $key => $val) {
    if (!isset($temp[$val['watcher_log']['server_name']])) {
        if ($val['watcher_log']['server_name'] !== '') {
            echo "<div class='col-sm-12'><hr></div><div class='col-sm-12'><div id='{$val['watcher_log']['server_name']}_la'></div></div>";
            echo "<div class='col-sm-12'><div id='{$val['watcher_log']['server_name']}_fs'></div></div>";
        }
    }
    $temp[$val['watcher_log']['server_name']] = $val['watcher_log']['server_name'];
}
?>