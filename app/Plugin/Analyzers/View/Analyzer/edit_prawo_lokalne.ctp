<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/analyzers">Analizator</a></li>
    <li><a href="/analyzers/analyzer/view/id:Prawo-Daty">Prawo-Daty</a></li>
    <li class="active">Prawo Województwa id:<?= $data['PrawoLokalne']['id']; ?></li>
</ol>
<div id="info" class="hidden alert alert-success margin-top-20"></div>
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a
            href="/analyzers/analyzer/editPrawoLokalne/<?= $data['PrawoLokalne']['id']; ?>">Dane</a></li>
    <? if (isset($data['PrawoLokalne']['next']) && is_array($data['PrawoLokalne']['next'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/analyzers/analyzer/editPrawoLokalne/<?= $data['PrawoLokalne']['next']['PrawoLokalne']['id']; ?>">Następne
                <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if (isset($data['PrawoLokalne']['prev']) && is_array($data['PrawoLokalne']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a
                href="/analyzers/analyzer/editPrawoLokalne/<?= $data['PrawoLokalne']['prev']['PrawoLokalne']['id']; ?>"><span
                    aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>
</div>
<div id="id" class="hidden"><?= $data['PrawoLokalne']['id']; ?></div>
<div class="row">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-4"><label class="pull-right">Tytuł:</label></div>
            <div class="col-sm-8"><textarea name="tytul" id="tytul" class="form-control" rows="8"
                                            readonly><?= $data['PrawoLokalne']['tytul']; ?></textarea></div>
        </div>
        <div class="row">
            <div class="col-sm-4"><label class="pull-right">Organ Wydający:</label></div>
            <div class="col-sm-8"><input name="organ_wydajacy_str" id="organ_wydajacy_str" class="form-control"
                                         value="<?= $data['PrawoLokalne']['organ_wydajacy_str']; ?>" readonly></div>
        </div>
        <div class="row">
            <div class="col-sm-4"><label class="pull-right">Rocznik:</label></div>
            <div class="col-sm-8"><input name="rocznik" id="rocznik" class="form-control"
                                         value="<?= $data['PrawoLokalne']['rocznik']; ?>" readonly></div>
        </div>
        <div class="row">
            <div class="col-sm-4"><label class="pull-right">Data Wydania:</label></div>
            <div class="col-sm-8"><input class="form-control" type="date" name="data_wydania" id="data_wydania"
                                         value="<?= $data['PrawoLokalne']['data_wydania']; ?>" readonly></div>
        </div>

        <div class="row">
            <div class="col-sm-4"><label class="pull-right">Data Wydania:</label></div>
            <div class="col-sm-8"><input class="form-control" type="date" name="data_poprawiona" id="data_poprawiona"
                                         value="<?= $data['PrawoLokalne']['data_poprawiona']; ?>"></div>
        </div>

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
                <button id="savebtn" class="btn btn-primary btn-lg">Zapisz zmiany</button>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
<iframe class="full-width" height="700" src="https://mojepanstwo.pl:2345/docs/<?= $data['PrawoLokalne']['dokument_id']; ?>.html">

</iframe>

    </div>

</div>

<? echo $this->html->script("Analyzers.edit_prawo_lokalne"); ?>