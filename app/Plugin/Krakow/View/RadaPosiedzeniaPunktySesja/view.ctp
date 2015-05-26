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
    <div class="col-sm-6">
        <form class="form-horizontal">
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

    </div>
</div>

<? echo $this->Html->script('Krakow.RadaPosiedzeniaPunktySesja/view'); ?>