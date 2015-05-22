<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/rada_posiedzenia">Posiedzenia Rady Miasta</a></li>
    <li class="active">Posiedzenie z dnia <?= $this->PLText->date($posiedzenie['Posiedzenia']['date']);?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['id'];?>">Dane</a></li>
    <li role="presentation"<?= ($this->action == 'editForm') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/editForm/<?=$posiedzenie['Posiedzenia']['id'];?>">Edycja</a></li>
    <li role="presentation"<?= ($this->action == 'joins') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/joins/<?=$posiedzenie['Posiedzenia']['id'];?>">Łączenie punktów</a></li>
    <? if(isset($posiedzenie['Posiedzenia']['next']) && is_array($posiedzenie['Posiedzenia']['next'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['next']['Posiedzenia']['id'];?>">Następne <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if(isset($posiedzenie['Posiedzenia']['prev']) && is_array($posiedzenie['Posiedzenia']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['prev']['Posiedzenia']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<div class="margin-top-10" id="data"></div>

<div id="data-json" data-value='<?=$punkty;?>'></div>
<? echo $this->Html->script('Krakow.RadaPosiedzenia/view'); ?>
<? echo $this->Html->css('Krakow.RadaPosiedzenia/view'); ?>