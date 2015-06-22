<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li class="active">Wskazniki</li>
</ol>

<div class="row">
    <div class="col-sm-10">
        <form method="get" id="szukacz" action="">
            <div class="input-group">
                <input class="form-control" name="search" id="search">
                <span class="input-group-btn"
                    ><button class="btn btn-primary">Szukaj</button>
                </span>
            </div>
        </form>
    </div>
    <div class="col-sm-2"><a href="/wskazniki/panel_wskazniki/add">
            <button class="btn btn-primary pull-right">Dodaj Nowy</button>
        </a></div>
</div>

<ul class="nav nav-tabs margin-top-10">
    <li role="presentation" class="active"><a>Wskaźniki</a></li>
</ul>

<? if (count($data)) { ?>
    <ul class="list-group margin-top-5 panel-items">
        <? foreach ($data as $row) { ?>
            <li class="list-group-item">
        <span class="pull-right">ID: <?= $row['PanelWskazniki']['id']; ?> <input id="delete"
                                                                             value="<?= $row['PanelWskazniki']['id']; ?>"
                                                                             type="checkbox"></span>
                <a href="/wskazniki/panel_wskazniki/edit/<?= $row['PanelWskazniki']['id']; ?>">
                    <?= $row['PanelWskazniki']['tytul']; ?>
                </a>
            </li>
        <? } ?>
    </ul>
        <button class="btn btn-danger pull-right" id="usun">Usuń</button>


    <br><br>
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

<? echo $this->html->script('Wskazniki.PanelWskazniki/index');