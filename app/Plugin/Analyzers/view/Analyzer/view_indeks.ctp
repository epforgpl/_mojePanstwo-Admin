<?php
echo $this->Html->script('Analyzers.highcharts');
echo $this->Html->script('Analyzers.highcharts-more');
echo $this->Html->script('Analyzers.timeago');
echo $this->Html->script('Analyzers.refresherIndeks');
echo $this->Html->css('Analyzers./Analyzer/view');


$data = json_decode($analyzer['AnalyzerExecution']['data'], true);


$dict = array(
    '0' => 'Nieprzetwarzane',
    '1' => 'W kolejce do przetwarzania',
    '2' => 'Aktualnie przetwarzane',
    '3' => 'OK',
    '4' => 'Brak danych',
    '5' => 'Błąd',
    '6' => 'Błąd',
    '7' => 'Błąd',
);

$jsdict = json_encode($dict);
?>
    <script>
        var dict =<?php echo $jsdict; ?>;
    </script>
<?php
$temp = array();
foreach ($data['wartosci'] as $key => $val) {
    if (!isset($temp[$val['objects']['dataset']])) {
        if ($val['objects']['dataset'] !== '') {
            echo "<div class='col-sm-12'><hr></div><div class='col-sm-12'><div id='{$val['objects']['dataset']}'></div></div>";
        }
    }
    $temp[$val['objects']['dataset']] = $val['objects']['dataset'];
}
?>