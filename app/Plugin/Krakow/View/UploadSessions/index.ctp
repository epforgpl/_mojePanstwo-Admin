<? echo $this->Html->css('Krakow.UploadSessions/view'); ?>
<? echo $this->Html->css('/lib/s3.jquery.fine-uploader/fine-uploader.min'); ?>

<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li class="active">Sesje</li>
</ol>

<div class="row margin-top-10">
    <div class="col-sm-12">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <a href="/krakow/upload_sessions/addForm" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;
                    Nowa sesja
                </a>
            </div>
        </div>
    </div>
</div>

<? if(count($data)) { ?>
    <table class="table table-striped table-hover margin-top-20">
        <thead>
            <tr>
                <th>Data plików</th>
                <th>Posiedzenie</th>
                <th>Pliki</th>
                <th></th>
                <th></th>
                <th></th>
                <th>Przetwarzanie</th>
                <th>Podgląd</th>
                <th>YouTube</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($data as $row) { ?>
                <tr>
                    <td>
                        <?= $this->PLText->date($row['RadyPosiedzeniaPliki']['cts']); ?>
                    </td>
                    <td>
                        <strong><?
                            switch($row['UploadSessions']['typ_id']) {
                                case '1': echo 'Rada Miasta'; break;
                                case '2': echo $row['UploadSessions']['label']; break;
                                case '3': echo 'Dzielnica ' . $row['UploadSessions']['label']; break;
                            }
                        ?></strong><br>
                        <?= $this->PLText->date($row['UploadSessions']['date']); ?>
                    </td>
                    <td>
                        <a href="/krakow/upload_sessions/view/<?= $row['UploadSessions']['id']; ?>">
                            <?= $row['UploadSessions']['files_count'] > 0 ? $row['UploadSessions']['files_count'] . '&nbsp;plik(i/ów)' : 'Dodaj pliki'; ?>
                        </a>
                    </td>
                    <td></td>
                    <td>
                        <?
                            $u = false;
                            if($row['RadyPosiedzeniaPliki']['target_id'] == '1') {
                                $u = 'http://przejrzystykrakow.pl/posiedzenia/' . $row['PlGminyKrakowPosiedzenia']['id'];
                            } else if($row['RadyPosiedzeniaPliki']['target_id'] == '2') {
                                $u = 'http://przejrzystykrakow.pl/komisje/' . $row['RadyPosiedzeniaPliki']['subtarget_id'] . '/posiedzenia/' . $row['RadyPosiedzeniaPliki']['posiedzenie_id'];
                            } else if($row['RadyPosiedzeniaPliki']['target_id'] == '3') {
                                $u = 'http://przejrzystykrakow.pl/dzielnice/' . $row['RadyPosiedzeniaPliki']['subtarget_id'] . '/rada_posiedzenia/' . $row['PlGminyKrakowDzielniceRadyPosiedzenia']['id'];
                            }
                        ?>
                        <? if($u) { ?>
                            <a href="<?= $u ?>" target="_blank">
                                PKRK
                            </a>
                        <? } ?>
                    </td>
                    <td>
                        <?
                        $u = false;
                        if($row['RadyPosiedzeniaPliki']['target_id'] == '1' && $row['PlGminyKrakowPosiedzenia']['yt_playlist_id'] != null) {
                            $u = 'https://www.youtube.com/playlist?list='. $row['PlGminyKrakowPosiedzenia']['yt_playlist_id'];
                        } else if($row['RadyPosiedzeniaPliki']['target_id'] == '2' && $row['RadyKomisjePosiedzenia']['yt_video_id'] != null) {
                            $u = 'http://www.youtube.com/watch?v=' . $row['RadyKomisjePosiedzenia']['yt_video_id'];
                        } else if($row['RadyPosiedzeniaPliki']['target_id'] == '3' && $row['RadyDzielnicePosiedzenia']['yt_video_id'] != null) {
                            $u = 'http://www.youtube.com/watch?v=' . $row['RadyDzielnicePosiedzenia']['yt_video_id'];
                        }
                        ?>
                        <? if($u) { ?>
                            <a href="<?= $u ?>" target="_blank">
                                YouTube
                            </a>
                        <? } ?>
                    </td>
                    <td>
                        <? if($row['UploadSessions']['finished']) {
                            $videojoin = false;
                            $videojoin_ts = null;
                            if($row['RadyPosiedzeniaPliki']['target_id'] == '2') {
                                $videojoin = $row['RadyKomisjePosiedzenia']['videojoin'];
                                $videojoin_ts = $row['RadyKomisjePosiedzenia']['videojoin_ts'];
                            } else if($row['RadyPosiedzeniaPliki']['target_id'] == '3') {
                                $videojoin = $row['RadyDzielnicePosiedzenia']['videojoin'];
                                $videojoin_ts = $row['RadyDzielnicePosiedzenia']['videojoin_ts'];
                            }

                            $label = isset($labels['videojoin'][$videojoin]) ? $labels['videojoin'][$videojoin] : false;
                            if($label) { ?>
                                <span title="<?= $videojoin_ts ?>" class="label label-<?= $label[1] ?>">
                                    <?= $label[0] ?>
                                </span>
                            <? }
                        } else { ?>
                            <p class="help-block">Sesja otwarta</p>
                        <? } ?>
                    </td>
                    <td>
                        <? if($row['UploadSessions']['finished']) {
                            $videopreview = false;
                            $videopreview_ts = null;
                            if($row['RadyPosiedzeniaPliki']['target_id'] == '2') {
                                $videopreview = $row['RadyKomisjePosiedzenia']['videopreview'];
                                $videopreview_ts = $row['RadyKomisjePosiedzenia']['videopreview_ts'];
                            } else if($row['RadyPosiedzeniaPliki']['target_id'] == '3') {
                                $videopreview = $row['RadyDzielnicePosiedzenia']['videopreview'];
                                $videopreview_ts = $row['RadyDzielnicePosiedzenia']['videopreview_ts'];
                            }

                            $label = isset($labels['videopreview'][$videopreview]) ? $labels['videopreview'][$videopreview] : false;
                            if($label) { ?>
                                <span title="<?= $videopreview_ts ?>" class="label label-<?= $label[1] ?>">
                                    <?= $label[0] ?>
                                </span>
                            <? }
                        } ?>
                    </td>
                    <td>
                        <? if($row['UploadSessions']['finished']) {
                            $videoyt = false;
                            $videoyt_ts = null;
                            if($row['RadyPosiedzeniaPliki']['target_id'] == '2') {
                                $videoyt = $row['RadyKomisjePosiedzenia']['videoyt'];
                                $videoyt_ts = $row['RadyKomisjePosiedzenia']['videoyt_ts'];
                            } else if($row['RadyPosiedzeniaPliki']['target_id'] == '3') {
                                $videoyt = $row['RadyDzielnicePosiedzenia']['videoyt'];
                                $videoyt_ts = $row['RadyDzielnicePosiedzenia']['videoyt_ts'];
                            }

                            $label = isset($labels['videoyt'][$videoyt]) ? $labels['videoyt'][$videoyt] : false;
                            if($label) { ?>
                                <span title="<?= $videoyt_ts ?>" class="label label-<?= $label[1] ?>">
                                    <?= $label[0] ?>
                                </span>
                            <? }
                        } ?>
                    </td>
                </tr>
            <? } ?>
        </tbody>
    </table>
<? } else { ?>
    <p class="block margin-top-10">Brak danych</p>
<? } ?>

<ul class="pagination">
    <?php
    echo $this->Paginator->prev(__('Poprzednia'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
    echo $this->Paginator->next(__('Następna'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    ?>
</ul>

<span class="pull-right">
    <? echo $this->Paginator->counter(
        'Strona {:page} z {:pages}, wyświetla {:current} rekordów z
     {:count} wszystkich, od {:start} do {:end}.'
    ); ?>
</span>