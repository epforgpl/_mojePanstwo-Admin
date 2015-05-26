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
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['next']['Posiedzenia']['id'];?>">Następne <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if(isset($posiedzenie['Posiedzenia']['prev']) && is_array($posiedzenie['Posiedzenia']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['prev']['Posiedzenia']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<? if(count($punkty)) { ?>
    <ul class="list-group margin-top-5 panel-items sortable">
        <? foreach($punkty as $punkt) { ?>
            <li class="list-group-item" data-source="<?= $punkt['source']; ?>" data-id="<?= $punkt['id']; ?>" <?= isset($punkt['punkt_id']) ? 'data-punkt-id="'.$punkt['punkt_id'].'"' : ''; ?>>
                <div class="row">
                    <div class="col-sm-11">
                        <?= $punkt['nr']; ?>.
                        <?= $punkt['tytul']; ?>
                    </div>
                    <div class="col-sm-1">
                        <span class="badge pull-right">
                            <?= $punkt['source']; ?>
                        </span>
                    </div>
                </div>
                <? if(!isset($punkt['punkt_id']))
                    echo '<ul class="list-group"></ul>'; ?>
            </li>
        <? } ?>
    </ul>
<? } else { ?>
    <p class="block margin-top-10">Brak danych</p>
<? } ?>