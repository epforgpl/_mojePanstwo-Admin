<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/bdl/podgrupy">BDL</a></li>
    <li><a href="/bdl/kategorie/index/<?= $kategoria['Kategorie']['id']; ?> "><?= $kategoria['Kategorie']['tytul']; ?></a></li>
    <li><a href="/bdl/grupy/index/<?= $grupa['Grupy']['id']; ?>"><?= $grupa['Grupy']['tytul']; ?></a></li>
    <li class="active"><?= $podgrupa['Podgrupy']['tytul']; ?></li>
</ol>
<div id="info" class="alert alert-success margin-top-20 hidden"></div>
<div id="id" class="hidden"><?= $podgrupa['Podgrupy']['id'] ?></div>
<article id="editor">
    <? if (!empty($podgrupa['Podgrupy']['opis'])) {
        echo $podgrupa['Podgrupy']['opis'];
    } ?>
</article>

<div class="pull-right"><button id="savebtn" class="btn-lg btn-primary">Save</button></div>

<? echo $this->Html->css('Bdl.Podgrupy/view'); ?>
<? echo $this->Html->script('Bdl.Podgrupy/bootstrap3-wysihtml5.all'); ?>
<? echo $this->Html->script('Bdl.Podgrupy/view'); ?>
<? echo $this->Html->script('Bdl.Podgrupy/bootstrap-wysihtml5.pl-PL'); ?>
<? echo $this->Html->css('Bdl.Podgrupy/bootstrap3-wysihtml5.min'); ?>