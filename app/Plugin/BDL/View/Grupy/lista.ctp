<ol class="breadcrumb">
    <li><a href="/">Dane</a></li>
    <li><a href="/bdl">BDL</a></li>
    <li><a href="/bdl/kategorie/lista">Kategorie</a></li>
    <li class="active">Grupy</li>
</ol>



<?if(count($data)) { ?>
    <ul class="list-group margin-top-5 panel-items">
        <? foreach($data as $row) { ?>
            <li class="list-group-item">
                <span class="pull-right">ID: <?= $row['Grupy']['id']; ?></span>
                <a href="/bdl/grupy/index/<?= $row['Grupy']['id']; ?>">
                    <?= $row['Grupy']['tytul']; ?>
                </a>
            </li>
        <? } ?>
    </ul>
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
     {:count} wszystkich, od {:start}, do {:end}.'
    ); ?>
</span>