<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/analyzers">Analizator</a></li>
    <li><a href="/analyzers/analyzer/id:Prawo">Prawo</a></li>
    <li class="active">Prawo Województwa id:<?= $data['PrawoLokalne']['id']; ?></li>
</ol>
<div id="info" class="hidden alert alert-success margin-top-20"></div>
<dic id="id" class="hidden"><?= $data['PrawoLokalne']['id']; ?></dic>
<div class="row">
    <div class="col-sm-4"><label class="pull-right">Tytuł:</label></div>
    <div class="col-sm-6"><textarea name="tytul" id="tytul" class="form-control" rows="4"
                                    readonly><?= $data['PrawoLokalne']['tytul']; ?></textarea></div>
</div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right">Organ Wydający:</label></div>
    <div class="col-sm-6"><input name="organ_wydajacy_str" id="organ_wydajacy_str" class="form-control"
                                 value="<?= $data['PrawoLokalne']['organ_wydajacy_str']; ?>"></div>
</div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right">Rocznik:</label></div>
    <div class="col-sm-6"><input name="rocznik" id="rocznik" class="form-control"
                                 value="<?= $data['PrawoLokalne']['rocznik']; ?>"></div>
</div>
<div class="row">
    <div class="col-sm-4"><label class="pull-right">Data Wydania:</label></div>
    <div class="col-sm-6"><input class="form-control" type="date" name="data_wydania" id="data_wydania"
                                 value="<?= $data['PrawoLokalne']['data_wydania']; ?>"></div>
</div>
<div class="row">
    <div class="col-sm-4"></div><div class="col-sm-6"><button id="savebtn" class="btn btn-primary btn-lg">Zapisz zmiany</button></div>
</div>

<? echo $this->html->script("Analyzers.edit_prawo_lokalne"); ?>