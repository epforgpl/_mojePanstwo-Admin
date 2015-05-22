<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/krakow/rada_posiedzenia">Posiedzenia Rady Miasta</a></li>
    <li class="active">Posiedzenie z dnia <?= $this->PLText->date($posiedzenie['Posiedzenia']['date']);?></li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<?= ($this->action == 'view') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/<?=$posiedzenie['Posiedzenia']['id'];?>">Dane</a></li>
    <li role="presentation"<?= ($this->action == 'editForm') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/editForm/<?=$posiedzenie['Posiedzenia']['id'];?>">Edycja</a></li>
    <li role="presentation"<?= ($this->action == 'joins') ? ' class="active"': ''; ?>><a href="/krakow/rada_posiedzenia/joins/<?=$posiedzenie['Posiedzenia']['id'];?>">Łączenie punktów</a></li>
    <? if(isset($posiedzenie['Posiedzenia']['next']) && is_array($posiedzenie['Posiedzenia']['next'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/joins/<?=$posiedzenie['Posiedzenia']['next']['Posiedzenia']['id'];?>">Następne <span aria-hidden="true">&raquo;</span></a></li>
    <? } ?>
    <? if(isset($posiedzenie['Posiedzenia']['prev']) && is_array($posiedzenie['Posiedzenia']['prev'])) { ?>
        <li role="presentation" class="pull-right"><a href="/krakow/rada_posiedzenia/joins/<?=$posiedzenie['Posiedzenia']['prev']['Posiedzenia']['id'];?>"><span aria-hidden="true">&laquo;</span> Poprzednie</a></li>
    <? } ?>
</ul>

<table class="table margin-top-10 joins">
    <tr>
        <th>Punkty z panelu</th>
        <th>Punkty wynikowe</th>
        <th>Punkty z BIP</th>
    </tr>
    <? $c = max(array(count($punkty), count($punktyBip), count($punktyWynik))); ?>
    <? for($i = 0; $i < $c; $i++) { ?>
        <tr>
            <? if(isset($punkty[$i])) { ?>
                <td data-id="">
                    <?=$punkty[$i]['Punkty']['nr'];?>.
                    <?=$punkty[$i]['Punkty']['tytul'];?>
                </td>
            <? } ?>
            <td <?= $punktyWynik[$i]['panel_id'] ? 'class="col"' : '' ?>>
                <? if(isset($punktyWynik[$i])) { ?>
                    <?=$punktyWynik[$i]['nr'];?>.
                    <?=$punktyWynik[$i]['tytul'];?>
                <? } ?>
            </td>
            <td>
                <? if(isset($punktyBip[$i])) { ?>
                    <?=$punktyBip[$i]['PunktyBip']['nr'];?>.
                    <?=$punktyBip[$i]['PunktyBip']['tytul_pelny'];?>
                <? } ?>
            </td>
        </tr>
    <? } ?>
</table>