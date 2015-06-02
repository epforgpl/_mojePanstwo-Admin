

<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/upload_sessions/addForm">Dodawanie plików</a></li>
    <li class="active">Sesja #<?= $session['UploadSessions']['hash']; ?></li>
</ol>

<div class="row margin-top-10">
    <div class="col-md-4">
        <dl>
            <dt>Posiedzenie</dt>
            <dd><?
                switch($session['UploadSessions']['typ_id']) {
                    case '1': echo 'Rada Miasta'; break;
                    case '2': echo 'Komisja Rady Miasta'; break;
                    case '3': echo 'Dzielnica'; break;
                }
            ?></dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>Nazwa</dt>
            <dd><?= $session['UploadSessions']['label']; ?></dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>Data</dt>
            <dd><?= $this->PLText->date($session['UploadSessions']['date']); ?></dd>
        </dl>
    </div>
</div>

<? pr($session); ?>