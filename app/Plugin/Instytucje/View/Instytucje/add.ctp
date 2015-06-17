<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/instytucje">Instytucje</a></li>
    <li class="active">Nowa</li>
</ol>
<div id="info" class="hidden alert alert-success margin-top-20"></div>

<div class="col-sm-6">
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Nazwa:</label></div>
        <div class="col-sm-10"><input id="nazwa" class="form-control input-lg text-center">
        </div>
    </div>


    <div class="row"><br>
        <div class="col-sm-2"><label class="pull-right">Email:</label></div>
        <div class="col-sm-10">
            <div class="text-center">
                <input type="email" id="email" class="form-control text-center">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Telefon:</label></div>
        <div class="col-sm-10">
            <div class="text-center">
                <input type="tel" id="phone" class="form-control text-center">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Fax:</label></div>
        <div class="col-sm-10">
            <div class="text-center">
                <input type="tel" id="fax" class="form-control text-center">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">WWW:</label></div>
        <div class="col-sm-10">
            <div class="text-center">
                <input type="url" id="www" class="form-control text-center">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Adres:</label></div>
        <div class="col-sm-10">
            <textarea id="adres_str" class="form-control"></textarea>
        </div>
    </div>
    <div class="row"><br>
        <div class="col-sm-2"><label class="pull-right">Rodzaj:</label></div>
        <div class="col-sm-10">
            <div class="text-center">
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender1"
                           value="1"> Męski
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender2"
                           value="2"> Żeński
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender3"
                           value="3"> Nijaki
                </label>
            </div>
        </div>
    </div>
    <div class="row"><br>
        <div class="col-sm-2"><label class="pull-right">Tagi:</label></div>
        <div class="col-sm-10"> <? foreach ($tags as $key => $val) { ?>
                <input type='checkbox' name="tagi" id="tag" value="<?= $key ?>"> <?= $val ?> <br>
            <? } ?></div>
    </div>
</div>

<div class="col-sm-6">
    <div class="row text-center">
        <label class="">Opis:</label>
    </div>
    <article id="editor">

    </article>
</div>


<div class="pull-right">
    <button id="addbtn" class="btn-lg btn-primary">Save</button>
</div>
<? echo $this->Html->script('Instytucje.Instytucje/bootstrap3-wysihtml5.all'); ?>
<? echo $this->Html->script('Instytucje.Instytucje/bootstrap-wysihtml5.pl-PL'); ?>
<? echo $this->Html->css('Instytucje.Instytucje/bootstrap3-wysihtml5.min'); ?>
<? echo $this->Html->css('Instytucje.Instytucje/view'); ?>
<? echo $this->Html->script('Instytucje.Instytucje/view'); ?>