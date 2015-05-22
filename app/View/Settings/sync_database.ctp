<ol class="breadcrumb">
    <li><a href="/settings">Ustawienia</a></li>
    <li class="active">Synchronizacja bazy</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <h4 class="text-muted">Synchronizacja bazy testowej</h4>
        <form action="/settings/syncDatabase" method="post">
            <input name="sync" class="btn btn-default margin-top-10" type="submit" value="Synchronizuj teraz"/>
        </form>
        <span class="block margin-top-10">
            Ostatnia synchronizacja:
            <?= $lastSync ? $this->PLText->date($lastSync['DatabaseSync']['created']).' ('.$lastSync['DatabaseSync']['ip'].')' : 'Brak'; ?>
        </span>
    </div>
</div>