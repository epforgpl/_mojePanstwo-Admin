<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>_mojePanstwo-Admin</title>
	<?php
		echo $this->Html->meta('app/webroot/icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('layout');
        echo $this->Html->script('jquery-2.1.4.min');
        echo $this->Html->script('bootstrap.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <? if($user) { ?>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" data-toggle="modal" data-target="#setDatabase">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    &nbsp; <?= $databaseType['value']; ?>
                </a>
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">
                <? if($menu) { ?>
                    <ul class="nav navbar-nav">
                        <? foreach($menu['items'] as $item) { ?>
                            <? if(isset($item['childrens']) && count($item['childrens']) > 0) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <?= $item['label']; ?> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <? foreach($item['childrens'] as $item) { ?>
                                            <li><a href="<?= $item['href']; ?>"><?= $item['label']; ?></a></li>
                                        <? } ?>
                                    </ul>
                                </li>
                            <? } else if(!isset($item['childrens'])) { ?>
                                <li><a href="<?= $item['href']; ?>"><?= $item['label']; ?></a></li>
                            <? } ?>
                        <? } ?>
                    </ul>
                <? } ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><?= $user['email']; ?></a></li>
                    <li><a href="/users/logout">Wyloguj się</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container content">
        <? $allow_error = $this->Session->flash('allow_error'); if($allow_error) { ?>
            <div class="alert alert-warning margin-top-20" role="alert">
                <?= $allow_error; ?>
            </div>
        <? } ?>
        <?php echo $this->fetch('content'); ?>
    </div>

    <div class="modal fade" id="setDatabase" tabindex="-1" role="dialog" aria-labelledby="setDatabaseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="/settings/setDatabase">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Wybierz bazę</h4>
                    </div>
                    <div class="modal-body">
                        <select class="form-control" name="type">
                            <? foreach($databaseTypes as $key => $value) { ?>
                                <option value="<?= $key; ?>"<?= ($databaseType['key'] == $key) ? ' selected' : ''; ?>>
                                    <?= $value; ?>
                                </option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                        <input type="submit" class="btn btn-primary" value="Zapisz"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <? } else { ?>
        <div class="container text-center">
            <h2>_mojePanstwo-Admin</h2>
            <a class="btn btn-primary margin-top-10" href="https://mojepanstwo.pl/auth/mojepanstwo">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                &nbsp;Zaloguj się
            </a>
            <? $msg = $this->Session->flash('auth_error'); if($msg) { ?>
                <div class="alert alert-warning margin-top-20" role="alert">
                    <?= $msg; ?>
                </div>
            <? } ?>
        </div>
    <? } ?>
</body>
</html>
