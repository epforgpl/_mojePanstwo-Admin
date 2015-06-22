<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/bdl/podgrupy">BDL</a></li>
    <li>
        <a href="/bdl/kategorie/index/<?= $kategoria['Kategorie']['id']; ?>"><?= $kategoria['Kategorie']['tytul']; ?></a>
    </li>
    <li><a href="/bdl/grupy/index/<?= $grupa['Grupy']['id']; ?>"><?= $grupa['Grupy']['tytul']; ?></a></li>
    <li class="active"><?= $podgrupa['Podgrupy']['tytul']; ?></li>
</ol>
<div id="info" class="alert alert-success margin-top-20 hidden"></div>
<div id="id" class="hidden"><?= $podgrupa['Podgrupy']['id'] ?></div>

<div class="row">
    <div class="col-sm-4 "><label class="pull-right margin-top-10">Nazwa:</label></div>
    <div class="col-sm-6"><input id="nazwa" class="form-control" value="<? if ($podgrupa['Podgrupy']['nazwa'] == '') {
            echo $podgrupa['Podgrupy']['tytul'];
        } else {
            echo $podgrupa['Podgrupy']['nazwa'];
        } ?>"</div>
    <div class="col-sm-2"></div>
</div><br>
<div class="row">
    <br><br>
    <article id="editor">
        <? if (!empty($podgrupa['Podgrupy']['opis'])) {
            echo $podgrupa['Podgrupy']['opis'];
        } ?>
    </article>
</div>
<div class="pull-right">
    <button id="savebtn" class="btn-lg btn-primary">Save</button>
</div>

<? echo $this->Html->css('Bdl.Podgrupy/view'); ?>
<? echo $this->Html->script('Bdl.Podgrupy/bootstrap3-wysihtml5.all'); ?>
<? echo $this->Html->script('Bdl.Podgrupy/view'); ?>
<? echo $this->Html->script('Bdl.Podgrupy/bootstrap-wysihtml5.pl-PL'); ?>
<? echo $this->Html->css('Bdl.Podgrupy/bootstrap3-wysihtml5.min'); ?>