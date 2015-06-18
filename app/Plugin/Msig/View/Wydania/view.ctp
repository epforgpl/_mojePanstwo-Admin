<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/msig/wydania">MSiG Wydania</a></li>
    <li class="active"><?= $wydanie['Wydania']['rocznik']; ?> nr. <?= $wydanie['Wydania']['nr']; ?>
        z <?= $this->PLText->date($wydanie['Wydania']['data']);; ?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"' : ''; ?>><a
            href="/msig/wydania/<?= $wydanie['Wydania']['id']; ?>">Dane</a></li>
    <? if (isset($wydanie['Wydania']['next']) && is_array($wydanie['Wydania']['next'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/msig/wydania/<?= $wydanie['Wydania']['next']['Wydania']['id']; ?>">Następne
                <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if (isset($wydanie['Wydania']['prev']) && is_array($wydanie['Wydania']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/msig/wydania/<?= $wydanie['Wydania']['prev']['Wydania']['id']; ?>"><span
                    aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<h1><?= $wydanie['Wydania']['rocznik']; ?> nr. <?= $wydanie['Wydania']['nr']; ?> z <?= $this->PLText->date($wydanie['Wydania']['data']); ?></h1>

<div class="row">
    <div class="col-sm-3">
        <ul class="list-group dzialy">
            <? foreach( $dzialy as $dzial ) {?>
            <li class="list-group-item">
                <h5><?= $dzial['nazwa'] ?></h5>
                <p class="text-center"><span class="label <? if($dzial['strona_od']) {?>label-normal<? } else { ?>label-danger<? } ?>"><?= $dzial['strona_od'] ?></span> - <span class="label <? if($dzial['strona_do']) {?>label-normal<? } else { ?>label-danger<? } ?>"><?= $dzial['strona_do'] ?></span></p>
            </li>
        <? } ?>
    </div>
    <div class="col-sm-9">
        <iframe class="full-width" height="700" src="https://mojepanstwo.pl:2345/docs/<?=$wydanie['Wydania']['dokument_id']?>.html"></iframe>
    </div>
</div>

<? echo $this->Html->css('Msig.Wydania/view'); ?>