<?php

App::uses('AppModel', 'Model');

class DatabaseSync extends AppModel {

    public $useTable = 'database_sync';

    public function __construct() {
        parent::__construct();
        $this->useDbConfig = 'default';
    }

}