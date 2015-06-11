<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/bdl">BDL</a></li>
    <? if (sizeof($kategorie) == 1) { ?>
        <li>
            <a href="/bdl/kategorie/index/<? echo array_keys($kategorie)[0]; ?>"> <?= $kategorie[array_keys($kategorie)[0]] ?></a>
        </li>
    <? } else { ?>
        <li><a href="/bdl/kategorie/lista">Kategorie</a></li>
    <? } ?>
    <? if (sizeof($grupy) == 1) { ?>
        <li>
            <a href="/bdl/grupy/index/<? echo array_keys($grupy)[0]; ?>"> <?= $grupy[array_keys($grupy)[0]] ?></a>
        </li>
    <? } else { ?>
        <li><a href="/bdl/grupy/lista">Grupy</a></li>
    <? } ?>
    <li class="active">Podgrupy</li>
</ol>
<div class="row">
    <form method="post" action="">
        <div class="col-sm-8">
            <label>Kategoria:</label>
            <select name="Kategoria">
                <option value="all">Wszystkie</option>
                <? foreach ($kategorie as $key => $title) { ?>
                    <option value="<?= $key ?>"><?= $title ?></option>
                <? } ?>
            </select>
            <br>
            <label>Grupa:</label>
            <select name="Grupa">
                <option value="all">Wszystkie</option>
                <? foreach ($grupy as $key => $title) { ?>
                    <option value="<?= $key ?>"><?= $title ?></option>
                <? } ?>
            </select>
        </div>
        <div class="col-sm-2 pull-right">
            <button class="btn-lg btn-primary btn-block">Wybierz</button>
        </div>
    </form>
</div>

<? if (count($data)) { ?>
    <ul class="list-group margin-top-5 panel-items">
        <? foreach ($data as $row) { ?>
            <li class="list-group-item">
                <span class="pull-right">ID: <?= $row['Podgrupy']['id']; ?></span>
                <a href="/bdl/podgrupy/view/<?= $row['Podgrupy']['id']; ?>">
                    <?= $row['Podgrupy']['tytul']; ?>
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