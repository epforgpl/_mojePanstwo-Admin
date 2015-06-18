<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/analyzers">Analizatory</a></li>
    <li class="active">Prawo-Daty</li>
</ol>

<div class="row">
    <ul class="nav nav-tabs">
        <?php foreach ($modes as $key => $label) { ?>
            <li role="presentation" <?= ($mode == $key) ? 'class="active"' : ''; ?>><a
                    href="/analyzers/analyzer/view/id:Prawo-Daty?mode=<?= $key; ?>"><?= $label; ?></a></li>
        <? } ?>
    </ul>

    <?
    //debug($dane);
    if (count($dane)) { ?>
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
    <? } else { ?>
        <p class="block margin-top-10">Brak danych</p>
    <? } ?>
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
</div>