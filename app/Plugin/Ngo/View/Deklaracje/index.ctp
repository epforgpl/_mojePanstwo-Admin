<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="">NGO</a></li>
    <li class="active">Deklaracje</li>
</ol>

<ul class="nav nav-tabs">
    <?php foreach ($modes as $key => $label) { ?>
        <li role="presentation" <?= ($mode == $key) ? 'class="active"' : ''; ?>><a
                href="/ngo/deklaracje?mode=<?= $key; ?>"><?= $label; ?></a></li>
    <? } ?>
</ul>

<? if (count($data)) { ?>
    <ul class="list-group margin-top-5 panel-items">
        <? foreach ($data as $row) { ?>
            <li class="list-group-item">
                <span class="pull-right"><? if ($row['Deklaracje']['position'] == '') {
                        echo "Brak funkcji";
                    } else { ?><?= $row['Deklaracje']['position']; ?><? } ?>
                    w <? if ($row['Deklaracje']['organization'] == '') {
                        echo "Brak organizacji";
                    } else { ?><?= $row['Deklaracje']['organization']; ?><? } ?></span>
                <a href="/ngo/deklaracje/view/<?= $row['Deklaracje']['id']; ?>">
                    <div><? if ($row['Deklaracje']['firstname'] == '') {
                            echo "Brak Imienia i Nazwiska";
                        } else { ?><?= $row['Deklaracje']['firstname']; ?> <?= $row['Deklaracje']['lastname']; ?><? } ?></div>
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