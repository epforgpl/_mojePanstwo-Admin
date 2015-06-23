<? $inst = $instytucja['Instytucje'] ?>
    <ol class="breadcrumb">
        <li><a href="/">Dane</a></li>
        <li><a href="/instytucje">Instytucje</a></li>
        <li class="active"><?= $inst['nazwa'] ?>
        </li>
    </ol>
    <div id="info" class="hidden alert alert-success margin-top-20"></div>



<div id="id" class="hidden"><?= $inst['id'] ?></div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-2"><label class="pull-right">Nazwa:</label></div>
            <div class="col-sm-10"><input id="nazwa" value="<?= $inst['nazwa'] ?>"
                                          class="form-control input-lg text-center">
            </div>
        </div>


        <div class="row"><br>
            <div class="col-sm-2"><label class="pull-right">Email:</label></div>
            <div class="col-sm-10">
                <div class="text-center">
                    <input type="email" id="email" class="form-control text-center" value="<?= $inst['email'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><label class="pull-right">Telefon:</label></div>
            <div class="col-sm-10">
                <div class="text-center">
                    <input type="tel" id="phone" class="form-control text-center" value="<?= $inst['phone'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><label class="pull-right">Fax:</label></div>
            <div class="col-sm-10">
                <div class="text-center">
                    <input type="tel" id="fax" class="form-control text-center" value="<?= $inst['fax'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><label class="pull-right">WWW:</label></div>
            <div class="col-sm-10">
                <div class="text-center">
                    <input type="url" id="www" class="form-control text-center" value="<?= $inst['www'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><label class="pull-right">Adres:</label></div>
            <div class="col-sm-10">
                <textarea id="adres_str" class="form-control"><?= $inst['adres_str'] ?></textarea>
            </div>
        </div>
        <div class="row"><br>
            <div class="col-sm-2"><label class="pull-right">Rodzaj:</label></div>
            <div class="col-sm-10">
                <div class="text-center">
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="gender1"
                               value="1" <? if ($inst['gender'] == '1') echo "checked" ?>> On
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="gender2"
                               value="2" <? if ($inst['gender'] == '2') echo "checked" ?>> Ona
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="gender3"
                               value="3" <? if ($inst['gender'] == '3') echo "checked" ?>> Ono
                    </label>
                </div>
            </div>
        </div>
        <div class="row"><br>
            <div class="col-sm-2"><label class="pull-right">Tagi:</label></div>
            <div class="col-sm-10"> <? foreach ($tags as $key => $val) { ?>
                    <input type='checkbox' name="tagi" id="tag" value="<?= $key ?>" <? foreach ($instytucja['Tagi'] as $k => $v) {
                        if ($v['id'] == $key) {
                            echo "checked";
                        }
                    } ?>> <?= $val ?> <br>
                <? } ?></div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="row text-center">
            <label class="">Opis:</label>
        </div>
        <article id="editor">
            <?= $inst['opis_html'] ?>
        </article>
    </div>


    <div class="pull-right">
        <button id="savebtn" class="btn-lg btn-primary">Save</button>
    </div>
<? echo $this->Html->script('Instytucje.Instytucje/bootstrap3-wysihtml5.all'); ?>
<? echo $this->Html->script('Instytucje.Instytucje/bootstrap-wysihtml5.pl-PL'); ?>
<? echo $this->Html->css('Instytucje.Instytucje/bootstrap3-wysihtml5.min'); ?>
<? echo $this->Html->css('Instytucje.Instytucje/view'); ?>
<? echo $this->Html->script('Instytucje.Instytucje/view'); ?>