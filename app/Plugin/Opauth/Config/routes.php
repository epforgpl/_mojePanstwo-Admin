<?php
/**
 * Routing for Opauth
 */
Router::connect('mojepanstwo.pl/auth/callback', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'callback'));
Router::connect('mojepanstwo.pl/auth/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index'));
