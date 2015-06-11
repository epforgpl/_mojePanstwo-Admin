<? echo $this->Html->css('Krakow.PosiedzeniaDzielnice/view'); ?>

<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/posiedzenia_dzielnice">Posiedzenia Dzielnice</a></li>
    <li class="active">Posiedzenie z <?= $this->PLText->date($posiedzenie['RadyDzielnicePosiedzenia']['date']);?></li>
</ol>

<ul class="nav nav-tabs">
    <? if(isset($posiedzenie['RadyDzielnicePosiedzenia']['next']) && is_array($posiedzenie['RadyDzielnicePosiedzenia']['next'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/posiedzenia_dzielnice/view/<?=$posiedzenie['RadyDzielnicePosiedzenia']['next']['RadyDzielnicePosiedzenia']['id'];?>">Następne <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if(isset($posiedzenie['RadyDzielnicePosiedzenia']['prev']) && is_array($posiedzenie['RadyDzielnicePosiedzenia']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/posiedzenia_dzielnice/view/<?=$posiedzenie['RadyDzielnicePosiedzenia']['prev']['RadyDzielnicePosiedzenia']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzednie</a></li>
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

<div id="data-posiedzenie-id" data-value="<?=$posiedzenie['RadyDzielnicePosiedzenia']['id'];?>"></div>
<div id="data-posiedzenie-date" data-value="<?=$posiedzenie['RadyDzielnicePosiedzenia']['date'];?>"></div>
<div id="data-json" data-value='<?=$debaty;?>'></div>

<link href="http://vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.11/video.js"></script>
<? echo $this->Html->script('jquery.autocomplete.min'); ?>
<? echo $this->Html->script('Krakow.PosiedzeniaDzielnice/view'); ?>