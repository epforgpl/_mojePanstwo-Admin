<?php
/**
 * Routing for Opauth
 */
Router::connect('https://mojepanstwo.pl/auth/callback', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'callback'));
Router::connect('https://mojepanstwo.pl/auth/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index'));
