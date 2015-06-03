<? echo $this->Html->css('Krakow.UploadSessions/add_form'); ?>
<? echo $this->Html->css('datepicker'); ?>

<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/upload_sessions/">Sesje</a></li>
    <li class="active">Dodawanie sesji</li>
</ol>

<div class="row margin-top-10">
    <div class="col-sm-12">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button id="create" type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>&nbsp;
                    Utwórz sesje
                </button>
            </div>
        </div>
    </div>
</div>

<form action="" method="post">
    <div class="row margin-top-10">
        <div class="col-lg-3">
            <div id="posiedzenie_input" class="form-group">
                <h3 class="text-muted">Posiedzenia</h3>
                <? if($this->Access->has(array('admin', 'pk-admin', 'pk-rada'))) { ?>
                    <div class="radio">
                        <label>
                            <input type="radio" class="posRadio" name="typ_id" value="1">
                            Rada Miasta
                        </label>
                    </div>
                <? } ?>
                <? if(!$this->Access->has('pk-rada')) { ?>
                    <? if(!$this->Access->has(array('pk-dzielnica6', 'pk-dzielnica14'))) { ?>
                        <div class="radio">
                            <label>
                                <input type="radio" class="posRadio" name="typ_id" value="2">
                                Komisja Rady Miasta
                            </label>
                        </div>
                    <? } ?>
                    <div class="radio">
                        <label>
                            <input type="radio" class="posRadio" name="typ_id" value="3">
                            Dzielnica Rady Miasta
                        </label>
                    </div>
                <? } ?>
            </div>
        </div>

        <div class="col-lg-6 height-transition">
            <div class="form-group hidden" id="form_group_komisja">
                <h3 class="text-muted">Komisje</h3>
                <?php foreach($komisje as $komisja) { ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="komisja_id" value="<?= $komisja['Komisje']['id']; ?>">
                            <?= $komisja['Komisje']['nazwa']; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <div class="form-group hidden" id="form_group_dzielnica">
                <h3 class="text-muted">Dzielnice</h3>
                <?php foreach($dzielnice as $dzielnica) { ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="dzielnica_id" value="<?= $dzielnica['Dzielnice']['id']; ?>"/>
                            <?= $dzielnica['Dzielnice']['nazwa']; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-3">
            <h3 class="text-muted">Data</h3>
            <div id="date" data-date="<?= date('Y-m-d'); ?>"></div>
            <input type="hidden" id="date_value" />
        </div>
    </div>

</form>

<? echo $this->Html->script('bootstrap-datepicker'); ?>
<? echo $this->Html->script('bootstrap-datepicker.pl'); ?>
<? echo $this->Html->script('Krakow.UploadSessions/add_form'); ?>