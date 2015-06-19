<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/ngo/deklaracje">NGO</a></li>
    <li><a href="/ngo/deklaracje">Deklaracje</a></li>
    <li class="active"><?= $deklaracja['Deklaracje']['organization']; ?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"' : ''; ?>><a
            href="/msig/wydania/<?= $deklaracja['Deklaracje']['id']; ?>">Deklaracja</a></li>
    <? if (isset($deklaracja['Deklaracje']['next']) && is_array($deklaracja['Deklaracje']['next'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/msig/wydania/<?= $deklaracja['Deklaracje']['next']['Deklaracje']['id']; ?>">Następne
                <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if (isset($deklaracja['Deklaracje']['prev']) && is_array($deklaracja['Deklaracje']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/msig/wydania/<?= $deklaracja['Deklaracje']['prev']['Deklaracje']['id']; ?>"><span
                    aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>
<div id="info" class="hidden"></div>
<div id="id" class="hidden"><?= $deklaracja['Deklaracje']['id']; ?></div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right margin-top-20">Imię i Nazwisko:</label></div>
    <div><h3><? if ($deklaracja['Deklaracje']['firstname'] == '') {
                echo "Brak Imienia i Nazwiska";
            } else { ?><?= $deklaracja['Deklaracje']['firstname']; ?> <?= $deklaracja['Deklaracje']['lastname']; ?><? } ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-6"><h5><?= $deklaracja['Deklaracje']['position']; ?> w </h5></div>
</div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right margin-top-10">Organizacja:</label></div>
    <div><h4><?= $deklaracja['Deklaracje']['organization']; ?></h4></div>
</div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right margin-top-10">Telefon:</label></div>
    <div><h4><?= $deklaracja['Deklaracje']['phone']; ?></h4></div>
</div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right margin-top-10">Email:</label></div>
    <div><h4><?= $deklaracja['Deklaracje']['email']; ?></h4></div>
</div>
<br>
<div class="row">
    <div class="col-sm-5">
        <button id="savebtn1" class="btn btn-lg btn-success pull-right" value="1">Zaakceptuj</button>
    </div>
    <div class="col-sm-4">
        <button id="savebtn2" class="btn btn-lg btn-danger pull-left" value="2">Odrzuć</button>
    </div>
</div>

<? echo $this->Html->script('Ngo.Deklaracje/view'); ?>
