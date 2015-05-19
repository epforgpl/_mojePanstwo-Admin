<h2 class="header">Posiedzenia Rady Miasta</h2>

<div role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Wszystkie</a></li>
        <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">Zaakceptowane</a></li>
        <li role="presentation"><a href="#c" role="tab" id="c-tab" data-toggle="tab" aria-controls="c">Do zaakceptowania</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
            <ul class="list-group margin-top-5">
                <? foreach($posiedzenia as $row) { ?>
                    <li class="list-group-item">
                        <span class="badge"><?= $row['Posiedzenia']['liczba_punktow']; ?></span>
                        <a href="/krakow/rada_posiedzenia/view/<?= $row['Posiedzenia']['id']; ?>">
                            <?= $row['Posiedzenia']['date']; ?>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
            <ul class="list-group margin-top-5">
                <? foreach($posiedzenia as $row) { ?>
                    <? if($row['Posiedzenia']['porzadek_akcept'] == '0') continue; ?>
                    <li class="list-group-item">
                        <span class="badge"><?= $row['Posiedzenia']['liczba_punktow']; ?></span>
                        <a href="/krakow/rada_posiedzenia/view/<?= $row['Posiedzenia']['id']; ?>">
                            <?= $row['Posiedzenia']['date']; ?>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="c" aria-labelledby="c-tab">
            <ul class="list-group margin-top-5">
                <? foreach($posiedzenia as $row) { ?>
                    <? if($row['Posiedzenia']['porzadek_akcept'] == '1') continue; ?>
                    <li class="list-group-item">
                        <span class="badge"><?= $row['Posiedzenia']['liczba_punktow']; ?></span>
                        <a href="/krakow/rada_posiedzenia/view/<?= $row['Posiedzenia']['id']; ?>">
                            <?= $row['Posiedzenia']['date']; ?>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
    </div>
</div>