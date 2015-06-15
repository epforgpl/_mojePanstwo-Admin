<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/instytucje">Instytucje</a></li>
    <li class="active"><?= $instytucja['Instytucje']['nazwa']; ?></li>
</ol>
<div id="info" class="alert alert-success margin-top-20 hidden"></div>
<div id="id" class="hidden"><?= $instytucja['Instytucje']['id'] ?></div>
<article id="editor">
    <? if (!empty($podgrupa['Podgrupy']['opis'])) {
        echo $podgrupa['Podgrupy']['opis'];
    } ?>
</article>

<div class="pull-right">
    <button id="savebtn" class="btn-lg btn-primary">Save</button>
</div>
