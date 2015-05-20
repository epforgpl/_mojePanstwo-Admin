<ol class="breadcrumb">
    <li><a href="/krakow/rada_posiedzenia">Posiedzenia Rady Miasta</a></li>
    <li class="active">Posiedzenie z dnia <?=$posiedzenie['Posiedzenia']['date'];?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['id'];?>">Dane</a></li>
    <li role="presentation"<?= ($this->action == 'editForm') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/editForm/<?=$posiedzenie['Posiedzenia']['id'];?>">Edycja</a></li>
</ul>

<div class="margin-top-10" id="data"></div>

<div id="data-json" data-value='<?=$punkty;?>'></div>
<? echo $this->Html->script('Krakow.view'); ?>
<? echo $this->Html->css('Krakow.view'); ?>