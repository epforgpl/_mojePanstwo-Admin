<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/zamowienia_publiczne/dokumenty">Zamówienia Publiczne</a></li>
    <li class="active"><?= $dokument['Dokumenty']['zamawiajacy_nazwa']; ?>
        z <?= $this->PLText->date($dokument['Dokumenty']['data_publikacji']);; ?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"' : ''; ?>><a
            href="/zamowienia_publiczne/dokumenty/<?= $dokument['Dokumenty']['id']; ?>">Dane</a></li>
    <? if (isset($dokument['Dokumenty']['next']) && is_array($dokument['Dokumenty']['next'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/zamowienia_publiczne/dokumenty/<?= $dokument['Dokumenty']['next']['Dokumenty']['id']; ?>">Następne
                <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if (isset($dokument['Dokumenty']['prev']) && is_array($dokument['Dokumenty']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/zamowienia_publiczne/dokumenty/<?= $dokument['Dokumenty']['prev']['Dokumenty']['id']; ?>"><span
                    aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<div class="margin-top-10 list-group list-group-item">
    <h4><?= $dokument['Dokumenty']['nazwa']; ?></h4>
    <br>

    <span class="pull-right">
        Cena MIN: <input name="cena_min" value="<?= $dokument['Dokumenty']['cena_min']; ?>">
        Cena: <input name="cena" value="<?= $dokument['Dokumenty']['cena']; ?>">
        Cena MAX: <input name="cena_max" value="<?= $dokument['Dokumenty']['cena_max']; ?>">
    </span>
    <br>
</div>
<div id="data"></div>

<div id="data-json" data-value='<?= $czesci; ?>'></div>
<? echo $this->Html->script('ZamowieniaPubliczne.Dokumenty/view'); ?>
<? echo $this->Html->css('ZamowieniaPubliczne.Dokumenty/view'); ?>