<?php
echo $this->Html->script('Analyzers.highcharts');
echo $this->Html->script('Analyzers.highcharts-more');
echo $this->Html->script('Analyzers.timeago');
echo $this->Html->script('Analyzers.refresher');
echo $this->Html->css('Analyzers./Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);

$dict = array(
    'ISAP_status' => array(
        'title' => 'ISAP_status',
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
        'title' => 'ISAP_analiza',
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
        'title' => 'ISAP_analiza_isip',
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
        'title' => 'DzU_analiza',
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
        'title' => 'MP_analiza',
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
        'title' => 'prawo_analiza',
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
        'title' => 'prawo_analiza_status',
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
        'title' => 'prawo_analiza_powiazania',
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
<div class="row">
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
</div>
<hr>
<div class="row">
    <ul class="nav nav-tabs">
        <?php foreach ($modes as $key => $label) { ?>
            <li role="presentation" <?= ($mode == $key) ? 'class="active"' : ''; ?>><a
                    href="/analyzers/analyzer/view/id:Prawo?mode=<?= $key; ?>"><?= $label; ?></a></li>
        <? } ?>
    </ul>

    <?
    //debug($dane);
    if (count($dane)) {
        if ($mode == 'woj') { ?>
            <ul class="list-group margin-top-5 panel-items">
                <? foreach ($dane as $row) {
                    $id = $row['PrawoLokalne']['wojewodztwo_id']; ?>
                    <li class="list-group-item">
                        <span class="pull-right">Ostatni z: <?= $this->PLText->date($row[0]['najnowsze']); ?></span>
                        <h4><?= $slownik[$id]; ?></h4> Liczba rekordów: <?= $row[0]['count']; ?>
                    </li>
                <? } ?>
            </ul>
        <? } elseif ($mode == 'gmi') { ?>
            <ul class="list-group margin-top-5 panel-items">
                <? foreach ($dane as $row) {
                    $id = $row['PrawoLokalne']['gmina_id'];
                    ?>
                    <li class="list-group-item">
                        <span class="pull-right">Ostatni z: <?= $this->PLText->date($row[0]['najnowsze']); ?></span>
                        <? if (!isset($slownik[$id])) { ?>
                            <h4>Brak Nazwy (<?= $id; ?>)</h4>Liczba rekordów: <?= $row[0]['count']; ?>
                        <? } else { ?>
                            <h4><?= $slownik[$id]; ?></h4> Liczba rekordów: <?= $row[0]['count']; ?>
                        <? } ?>
                    </li>
                <? } ?>
            </ul>
        <? } elseif ($mode == 'inst') { ?>
            <ul class="list-group margin-top-5 panel-items">
                <? foreach ($dane as $row) {
                    $id = $row['PrawoUrzedowe']['instytucja_id'];
                    ?>
                    <li class="list-group-item">
                        <span class="pull-right">Ostatni z: <?= $this->PLText->date($row[0]['najnowsze']); ?></span>
                        <? if (!isset($slownik[$id])) { ?>
                            <h4>Brak Nazwy (<?= $id; ?>)</h4>Liczba rekordów: <?= $row[0]['count']; ?>
                        <? } else { ?>
                            <a href="\instytucje\instytucje\view\<?= $id; ?>"><h4><?= $slownik[$id]; ?></h4>
                            </a> Liczba rekordów: <?= $row[0]['count']; ?>
                        <? } ?>
                    </li>
                <? } ?>
            </ul>
        <? } elseif ($mode == 'err') {?>
            <ul class="list-group margin-top-5 panel-items">
                <? foreach ($dane as $row) {
                    $id = $row['PrawoLokalne']['id'];
                    ?>
                    <li class="list-group-item">
                        <span
                            class="pull-right"><?= $this->PLText->date($row['PrawoLokalne']['data_wydania']); ?> z rocznika <?= $row['PrawoLokalne']['rocznik']; ?></span>
                        <a href="\analyzers\analyzer\editPrawoLokalne\<?= $id; ?>"><?= $row['PrawoLokalne']['tytul']; ?>
                        </a>
                    </li>
                <? } ?>
            </ul>
        <? } ?>
    <? } else { ?>
        <p class="block margin-top-10">Brak danych</p>
    <? } ?>

    <? if ($mode !== 'woj') { ?>
        <ul class="pagination">
            <?php
            echo $this->Paginator->prev(__('Poprzednia'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
            echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
            echo $this->Paginator->next(__('Następna'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
            ?>
        </ul>

        <span class="pull-right">
    <? echo $this->Paginator->counter(
        'Strona {:page} z {:pages}, wyświetla {:current} rekordów z
     {:count} wszystkich, od {:start}, do {:end}.'
    ); ?>
</span>
    <? } ?>
</div>