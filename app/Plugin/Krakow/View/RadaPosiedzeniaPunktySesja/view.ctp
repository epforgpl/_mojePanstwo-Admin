<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/rada_posiedzenia">Posiedzenia Rady Miasta</a></li>
    <li><a href="/krakow/rada_posiedzenia/editForm/<?= $data['item']['posiedzenie_id']; ?>">Posiedzenie z dnia <?= $this->PLText->date($data['item']['posiedzenie_data']);?></a></li>
    <li class="active">#<?= $data['item']['nr']; ?> <?= substr($data['item']['tytul'], 0, 50); ?>..</li>
</ol>

<ul class="nav nav-tabs">
    <? if($data['item']['next']) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia_punkty_sesja/<?=$data['item']['next']['id'];?>">Następny <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if($data['item']['prev']) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia_punkty_sesja/<?=$data['item']['prev']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzedni</a></li>
    <? } ?>
</ul>

<div class="row margin-top-10">
    <div class="col-sm-12">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button id="save" type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;
                    Zapisz
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row margin-top-10">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-2 text-right">
                <h1 class="margin-0 padding-0">#<?= $data['item']['nr']; ?></h1>
            </div>
            <div class="col-sm-10">
                <h4 class="text-muted">Posiedzenie z dnia <?= $this->PLText->date($data['item']['posiedzenie_data']);?></h4>
            </div>
        </div>
        <form class="form-horizontal margin-top-10">
            <div class="form-group">
                <label for="inputTitle" class="col-sm-2 control-label">Tytuł</label>
                <div class="col-sm-10">
                    <textarea rows="5" class="form-control" id="inputTitle" placeholder="Tytuł"><?= $data['item']['tytul']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputDesc" class="col-sm-2 control-label">Opis</label>
                <div class="col-sm-10">
                    <textarea rows="3" class="form-control" id="inputDesc" placeholder="Opis"><?= $data['item']['opis']; ?></textarea>
                </div>
            </div>
        </form>

        <div class="row setTimes">
            <div class="col-md-6">
                <div data-name="config" data-type="start"></div>
            </div>
            <div class="col-md-6">
                <div data-name="config" data-type="stop"></div>
            </div>
        </div>

        <h3>Następny punkt</h3>
        <? if($data['item']['next']) { ?>
            <p>
                <b>#<?= $data['item']['next']['nr']; ?></b>
                <?= $data['item']['next']['tytul']; ?>
            </p>
            <p>
                <?= @$data['item']['next']['opis']; ?>
            </p>
            <? if($data['item']['druk_numer']) { ?>
                <p>
                    Numer druku: <b><?= $data['item']['druk_numer']; ?></b>
                </p>
            <? } ?>
        <? } else { ?>
            <p>Brak</p>
        <? } ?>
    </div>
    <div class="col-sm-6">
        <div data-name="video" data-type="start"></div>
        <div data-name="video" data-type="stop"></div>
    </div>
</div>

<div id="data-id" data-value='<?= $data['item']['id']; ?>'></div>
<div id="data-item" data-json='<?= json_encode($data['item']); ?>'></div>
<div id="data-files" data-json='<?= json_encode($data['pliki']); ?>'></div>

<link href="http://vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.11/video.js"></script>
<? echo $this->Html->script('Krakow.RadaPosiedzeniaPunktySesja/view'); ?>