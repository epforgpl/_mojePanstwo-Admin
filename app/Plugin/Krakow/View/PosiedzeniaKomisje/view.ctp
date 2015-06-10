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

<div class="row margin-top-10">
    <div class="col-sm-12">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button id="add" type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;
                    Nowy punkt
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

<div id="posiedzenie"></div>

<div id="data-posiedzenie-id" data-value="<?=$posiedzenie['RadyKomisjePosiedzenia']['id'];?>"></div>
<div id="data-posiedzenie-date" data-value="<?=$posiedzenie['RadyKomisjePosiedzenia']['date'];?>"></div>
<div id="data-json" data-value='<?=$debaty;?>'></div>

<link href="http://vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.11/video.js"></script>
<? echo $this->Html->script('jquery.autocomplete.min'); ?>
<? echo $this->Html->script('Krakow.PosiedzeniaKomisje/view'); ?>