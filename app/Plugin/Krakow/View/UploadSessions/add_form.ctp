<? echo $this->Html->css('Krakow.UploadSessions/jquery-ui.min'); ?>
<? echo $this->Html->css('Krakow.UploadSessions/jquery-ui.theme.min'); ?>

<form action="" method="post">
    <div class="row margin-top-10">
        <div class="col-lg-4">
            <div id="posiedzenie_input" class="form-group">
                <h3 class="text-muted">Posiedzenia</h3>
                <div class="radio">
                    <label>
                        <input type="radio" class="posRadio" name="typ_id" value="1">
                        Rada Miasta
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" class="posRadio" name="typ_id" value="2">
                        Komisja Rady Miasta
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" class="posRadio" name="typ_id" value="3">
                        Dzielnica Rady Miasta
                    </label>
                </div>
            </div>
        </div>

        <div class="col-lg-4 height-transition">
            <div class="form-group" id="form_group_komisja">
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
            <div class="form-group" id="form_group_dzielnica">
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
        <div class="col-lg-4">
            <div class="form-group" id="dateEl">
                <h3 class="text-muted">Data</h3>
                <input class="form-control" name="date" type="text" style="width: 280px;" value="<?= date('Y-m-d'); ?>" id="date"/>
            </div>
        </div>
    </div>

    <div class="col-lg-12 text-center btn-cont">
        <input class="btn btn-md btn-primary" type="submit" name="create_upload_session" value="Wgraj pliki" />
    </div>
</form>

<? echo $this->Html->script('Krakow.UploadSessions/jquery-ui.min'); ?>
<? echo $this->Html->script('Krakow.UploadSessions/add_form'); ?>