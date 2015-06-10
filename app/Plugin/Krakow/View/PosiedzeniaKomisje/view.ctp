<? echo $this->Html->css('Krakow.PosiedzeniaKomisje/view'); ?>

<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/posiedzenia_komisje">Posiedzenia Komisje</a></li>
    <li class="active">Posiedzenie z <?= $this->PLText->date($posiedzenie['RadyKomisjePosiedzenia']['date']);?></li>
</ol>

<ul class="nav nav-tabs">
    <? if(isset($posiedzenie['RadyKomisjePosiedzenia']['next']) && is_array($posiedzenie['RadyKomisjePosiedzenia']['next'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/posiedzenia_komisje/view/<?=$posiedzenie['RadyKomisjePosiedzenia']['next']['RadyKomisjePosiedzenia']['id'];?>">Następne <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if(isset($posiedzenie['RadyKomisjePosiedzenia']['prev']) && is_array($posiedzenie['RadyKomisjePosiedzenia']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/posiedzenia_komisje/view/<?=$posiedzenie['RadyKomisjePosiedzenia']['prev']['RadyKomisjePosiedzenia']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<div id="posiedzenie"></div>

<div id="data-posiedzenie-id" data-value="<?=$posiedzenie['RadyKomisjePosiedzenia']['id'];?>"></div>
<div id="data-posiedzenie-date" data-value="<?=$posiedzenie['RadyKomisjePosiedzenia']['date'];?>"></div>
<div id="data-json" data-value='<?=$debaty;?>'></div>

<link href="http://vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.11/video.js"></script>
<? echo $this->Html->script('jquery.autocomplete.min'); ?>
<? echo $this->Html->script('Krakow.PosiedzeniaKomisje/view'); ?>