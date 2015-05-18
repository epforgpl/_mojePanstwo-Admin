<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>_mojePanstwo-Admin</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('layout');
        echo $this->Html->script('jquery-2.1.4.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a href="../" class="navbar-brand">_mojePanstwo-Admin</a>
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">
                <ul class="nav navbar-nav navbar-right">
                    <? if($user) { ?>
                        <li><a href="#"><?= $user['email']; ?></a></li>
                        <li><a href="/users/logout">Wyloguj się</a></li>
                    <? } else { ?>
                        <li><a href="/auth/mojepanstwo">Zaloguj się</a></li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>
