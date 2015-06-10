<?php

App::uses('AppShell', 'Console/Command');
App::uses('ConnectionManager', 'Model');

class DatabaseShell extends AppShell {

    private $dbTest;
    private $dbProd;

    private $tables;
    private static $limit = 999;

    public function __construct() {
        parent::__construct();
        ClassRegistry::init('AppModel');
        $this->tables = AppModel::getTables();
        $this->dbTest = ConnectionManager::getDataSource('test');
        $this->dbProd = ConnectionManager::getDataSource('prod');
    }

    /*
     * Importowanie tabel z bazy prod do test
     */
    public function sync() {
        foreach($this->tables as $table) {
            $this->out($table);
            try {
                $this->dbTest->execute('DROP TABLE `' . $table . '`');
            } catch(Exception $e) {
                $this->out($e->getMessage());
            }

            $file = TMP . $table . '.sql';
            $conf = $this->dbProd->config;
            exec('mysqldump -h '.$conf["host"].' -u '.$conf["login"].' --password=\''.$conf["password"].'\' --default-character-set=utf8 --opt --where="1 ORDER BY id DESC limit '.self::$limit.'" '.$conf["database"].' '.$table.' -r '.$file);
            $sql = file_get_contents($file);
            try {
                $this->dbTest->execute($sql);
            } catch(Exception $e) {
                $this->out($e->getMessage());
            }

            unlink($file);
        }
    }

}