<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li class="active">Instytucje</li>
</ol>
<div class="row">
    <form method="get" id="tag" action="../instytucje">
        <div class="col-sm-4">
            <label>Tag:</label>
            <select name="Tag" id="wybortagu">
                <option value="all">Wszystkie</option>
                <? foreach ($tagi as $key => $nazwa) { ?>
                    <option value="<?= $key ?>"<?
                    if (isset($this->params['url']['Tag'])) {
                        if ($key == $this->params['url']['Tag']) {
                            echo "selected";
                        }
                    }
                    ?>><?= $nazwa ?></option>
                <? } ?>
            </select>
        </div>
    </form>
    <div class="col-sm-4">
        <form method="get" id="szukacz" action=""><input name="search" id="search">
            <button class="btn btn-sm btn-primary">Szukaj</button>
        </form>
    </div>
    <div class="col-sm-4"><a href="/instytucje/instytucje/add">
            <button class="btn btn-primary pull-right">Nowa</button>
        </a></div>
</div>

<? if (count($data)) { ?>
    <ul class="list-group margin-top-5 panel-items">
        <? foreach ($data as $row) { ?>
            <li class="list-group-item">
        <span class="pull-right">ID: <?= $row['Instytucje']['id']; ?> <input id="delete"
                                                                             value="<?= $row['Instytucje']['id']; ?>"
                                                                             type="checkbox"></span>
                <a href="/instytucje/instytucje/view/<?= $row['Instytucje']['id']; ?>">
                    <?= $row['Instytucje']['nazwa']; ?>
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

<? echo $this->HTML->script('Instytucje.Instytucje/index'); ?>