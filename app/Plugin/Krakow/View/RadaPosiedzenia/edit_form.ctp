<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/rada_posiedzenia">Posiedzenia Rady Miasta</a></li>
    <li class="active">Posiedzenie z dnia <?= $this->PLText->date($posiedzenie['Posiedzenia']['date']);?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['id'];?>">Punkty</a></li>
    <li role="presentation"<?= ($this->action == 'editForm') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/editForm/<?=$posiedzenie['Posiedzenia']['id'];?>">Punkty podczas sesji</a></li>
    <li role="presentation"<?= ($this->action == 'import') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/import/<?=$posiedzenie['Posiedzenia']['id'];?>">Łączenie punktów</a></li>
    <? if(isset($posiedzenie['Posiedzenia']['next']) && is_array($posiedzenie['Posiedzenia']['next'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/editForm/<?=$posiedzenie['Posiedzenia']['next']['Posiedzenia']['id'];?>">Następne <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if(isset($posiedzenie['Posiedzenia']['prev']) && is_array($posiedzenie['Posiedzenia']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/editForm/<?=$posiedzenie['Posiedzenia']['prev']['Posiedzenia']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<div class="row margin-top-10">
    <div class="col-md-6">
        <div id="stopwatch"></div>
    </div>
    <div class="col-md-6">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button id="import" type="button" class="btn btn-default">
                    <span class=" glyphicon glyphicon-download-alt" aria-hidden="true"></span>&nbsp;
                    Import
                </button>
            </div>
            <div class="btn-group" role="group">
                <button id="add" type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;
                    Dodaj
                </button>
            </div>
            <div class="btn-group" role="group">
                <button id="save" type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;
                    Zapisz
                </button>
            </div>
        </div>
    </div>
</div>
<div id="points" class="list-group margin-top-10"></div>

<div id="data-posiedzenie-id" data-value="<?=$posiedzenie['Posiedzenia']['id'];?>"></div>
<div id="data-posiedzenie-date" data-value="<?=$posiedzenie['Posiedzenia']['date'];?>"></div>
<div id="data-json" data-value='<?=$punkty;?>'></div>

<? echo $this->Html->script('jquery.sortable.min'); ?>
<? echo $this->Html->script('Krakow.RadaPosiedzenia/edit'); ?>
<? echo $this->Html->css('Krakow.RadaPosiedzenia/view'); ?>