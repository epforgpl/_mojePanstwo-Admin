<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/wskazniki/panel_wskazniki">Wskaźniki</a></li>
    <li class="active">Nowy</li>
</ol>
<div id="info" class="hidden alert margin-top-20"></div>
<div id="mainid" class="hidden"></div>
<div class="row">
    <div class="row">
        <div class="col-sm-2"><label class="pull-right margin-top-10">Tytuł:</label></div>
        <div class="col-sm-10"><input id="nazwa" class="form-control input-lg text-center margin-top-5">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right margin-top-10">Nazwa skrócona:</label></div>
        <div class="col-sm-10"><input id="nazwa_skr" class="form-control input-lg text-center margin-top-5">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Opis:</label></div>
    </div>
    <article id="editor">

    </article>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right margin-top-10">Adres do arkusza:</label></div>
        <div class="col-sm-10"><input id="url" class="form-control input-lg text-center margin-top-5">
        </div>
    </div>
</div>

<div class="row">
    <div class="pull-right">
        <button id="addbtn" class="btn-lg btn-primary margin-top-20">Save</button>
    </div>
</div>

<? echo $this->Html->script('Wskazniki.PanelWskazniki/bootstrap3-wysihtml5.all'); ?>
<? echo $this->Html->script('Wskazniki.PanelWskazniki/bootstrap-wysihtml5.pl-PL'); ?>
<? echo $this->Html->css('Wskazniki.PanelWskazniki/bootstrap3-wysihtml5.min'); ?>
<? echo $this->Html->script('Wskazniki.PanelWskazniki/import'); ?>
<? echo $this->Html->css('Wskazniki.PanelWskazniki/import'); ?>