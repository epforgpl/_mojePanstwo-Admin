<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/wskazniki/panel_wskazniki">Wskaźniki</a></li>
    <li class="active"><?= $wskazniki['tytul'] ?></li>
</ol>
<div id="info" class="hidden alert alert-success margin-top-20"></div>
<div id="mainid" class="hidden"><?= $wskazniki['id'] ?></div>
<div class="col-sm-6">
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Tytuł:</label></div>
        <div class="col-sm-10"><input id="nazwa" class="form-control input-lg text-center"
                                      value="<?= $wskazniki['tytul'] ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Opis:</label></div>
    </div>
    <article id="editor">
        <?= $wskazniki['opis'] ?>
    </article>
</div>
<div class="col-sm-6">
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Licznik:</label></div>
        <div class="col-sm-10">
            <div class="row">
                <ul id="listalicznik" class="list-group margin-top-5 panel-items">
                    <? foreach ($podgrupy as $row) {
                        if ($row['PanelWskaznikiBdlPodgrupy']['L_M'] == 'licznik') {
                            ?>
                            <li class="list-group-item"
                                id="<?= $row['PanelWskaznikiBdlPodgrupy']['BDL_podgrupa_id'] ?>">
                                <div class="row">
                                    <?= $row['tytul'] ?>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form>
                                            <label class="radio-inline"><input name="znak" type="radio"
                                                                               value="1" <? if ($row['PanelWskaznikiBdlPodgrupy']['P_N'] == '1') {
                                                    echo "checked";
                                                } ?>> +</label>
                                            <label class="radio-inline"><input name="znak" type="radio" value="-1"
                                                    <? if ($row['PanelWskaznikiBdlPodgrupy']['P_N'] == '-1') {
                                                        echo "checked";
                                                    } ?>> - </label>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="pull-right btn-sm btn-danger" id="remove">x</button>
                                    </div>
                                </div>
                            </li>
                        <?
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="row">
                <button id="licznik" class="btn btn-primary pull-right">Dodaj Wskażnik</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"><label class="pull-right">Mianownik:</label></div>
        <div class="col-sm-10">
            <div class="row">
                <ul id="listamianownik" class="list-group margin-top-5 panel-items">
                    <? foreach ($podgrupy as $row) {
                        if ($row['PanelWskaznikiBdlPodgrupy']['L_M'] == 'mianownik') {
                            ?>
                            <li class="list-group-item"
                                id="<?= $row['PanelWskaznikiBdlPodgrupy']['BDL_podgrupa_id'] ?>">
                                <div class="row">
                                    <?= $row['tytul'] ?>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form>
                                            <label class="radio-inline"><input name="znak" type="radio"
                                                                               value="1" <? if ($row['PanelWskaznikiBdlPodgrupy']['P_N'] == '1') {
                                                    echo "checked";
                                                } ?>> +</label>
                                            <label class="radio-inline"><input name="znak" type="radio" value="-1"
                                                    <? if ($row['PanelWskaznikiBdlPodgrupy']['P_N'] == '-1') {
                                                        echo "checked";
                                                    } ?>> - </label>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="pull-right btn-sm btn-danger" id="remove">x</button>
                                    </div>
                                </div>
                            </li>
                        <?
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="row">
                <button id="mianownik" class="btn btn-primary pull-right">Dodaj Wskażnik</button>
            </div>
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
<? echo $this->Html->script('Wskazniki.PanelWskazniki/add'); ?>
<? echo $this->Html->css('Wskazniki.PanelWskazniki/add'); ?>


<div id="Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Wybierz wskaźnik, który chcesz dodać:</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input class="form-control" name="search" id="search">
                <span class="input-group-btn"
                    ><button id="search-btn" class="btn btn-primary">Szukaj</button>
                </span>
                </div>
                <ul id="lista" class="list-group margin-top-5 panel-items">
                </ul>

                <p class="text-info">
                    <small>Podwójne kliknięcie doda wybrany wskaźnik do licznika</small>
                </p>
            </div>
        </div>
    </div>
</div>
