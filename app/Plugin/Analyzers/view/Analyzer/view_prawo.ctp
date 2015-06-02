<?php
echo $this->Html->script('Analyzers.highcharts');
echo $this->Html->script('Analyzers.highcharts-more');
echo $this->Html->script('Analyzers.timeago');
echo $this->Html->script('Analyzers.refresher');
echo $this->Html->css('Analyzers./Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);

$dict = array(
    'ISAP_status' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'ISAP_status_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'ISAP_status_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'ISAP_analiza' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'ISAP_analiza_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'ISAP_analiza_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'ISAP_analiza_isip' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'ISAP_analiza_isip_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'ISAP_analiza_isip_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),


    'DzU_analiza' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'DzU_analiza_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'DzU_analiza_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),


    'MP_analiza' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'MP_analiza_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'MP_analiza_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),


    'prawo_analiza' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'prawo_analiza_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'prawo_analiza_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'prawo_analiza_status' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'prawo_analiza_status_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'prawo_analiza_status_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'prawo_analiza_powiazania' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'prawo_analiza_powiazania_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'prawo_analiza_powiazania_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
);

$jsdict = json_encode($dict);
?>
    <script>
        var dict =<?php echo $jsdict; ?>;
    </script>
<?php

foreach ($data as $key => $val) {

    if (strpos($key, 'err') !== false) {
        echo "<div id='$key' class='col-sm-3 label-danger text-white'></div><BR>";
    } elseif (strpos($key, 'corr') !== false) {
        echo "<div id='$key' class='col-sm-3 label-success text-white'></div><BR>";
    } elseif (strpos($key, 'wydania') !== false) {
        echo "<div id='$key' class='col-sm-3 label-info text-white'></div>";
    } else {
        echo "<div class='col-sm-12'><hr></div><div class='col-sm-9'><div id='$key'></div></div>";
    }
}
?>