<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/msig/wydania">MSiG Wydania</li>
    </a></li>
    <li class="active"><?= $wydanie['Wydania']['rocznik']; ?> nr. <?= $wydanie['Wydania']['nr']; ?>
        z <?= $this->PLText->date($wydanie['Wydania']['data']);; ?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"' : ''; ?>><a
            href="/zamowienia_publiczne/wydaniey/<?= $wydanie['Wydania']['id']; ?>">Dane</a></li>
    <? if (isset($wydanie['Wydania']['next']) && is_array($wydanie['Wydania']['next'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/zamowienia_publiczne/wydaniey/<?= $wydanie['Wydania']['next']['Wydania']['id']; ?>">Następne
                <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if (isset($wydanie['Wydania']['prev']) && is_array($wydanie['Wydania']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/zamowienia_publiczne/wydaniey/<?= $wydanie['Wydania']['prev']['Wydania']['id']; ?>"><span
                    aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<div class="margin-top-10 list-group list-group-item">
    <h4><?= $wydanie['Wydania']['rocznik']; ?> nr. <?= $wydanie['Wydania']['nr']; ?> z <?= $this->PLtext->date($wydanie['Wydania']['data']); ?></h4>

</div>
<div id="data"></div>

<div id="data-json" data-value='<?= $dzialy; ?>'></div>
<? echo $this->Html->script('Msig.Wydania/view'); ?>
<? echo $this->Html->css('Msig.Wydania/view'); ?>