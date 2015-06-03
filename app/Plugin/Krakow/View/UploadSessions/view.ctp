<? echo $this->Html->css('Krakow.UploadSessions/view'); ?>
<? echo $this->Html->css('/lib/s3.jquery.fine-uploader/fine-uploader.min'); ?>

<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/upload_sessions/">Sesje</a></li>
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

<div class="row">
    <div id="fine-uploader"></div>
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader">
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span>Przeciągnij pliki tutaj</span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Dodaj plik</div>
            </div>
	    <span class="qq-drop-processing-selector qq-drop-processing">
	      <span>Przetwarzam pliki...</span>
	      <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
	    </span>
            <ul class="qq-upload-list-selector qq-upload-list">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"></span>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <a class="qq-upload-cancel-selector qq-upload-cancel" href="#">Anuluj</a>
                    <a class="qq-upload-retry-selector qq-upload-retry" href="#">Wznów</a>
                    <a class="qq-upload-delete-selector qq-upload-delete" href="#">Skasuj</a>
                    <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>
        </div>
    </script>
</div>

<div data-name='config' data-json='<?= $config; ?>'></div>
<div data-name='id' data-value='<?= $session['UploadSessions']['id']; ?>'></div>

<? echo $this->Html->script('/lib/s3.jquery.fine-uploader/s3.jquery.fine-uploader.min'); ?>
<? echo $this->Html->script('Krakow.UploadSessions/view'); ?>