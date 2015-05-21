<?php

App::uses('ConnectionManager', 'Model');

class DatabaseShell extends AppShell {

    private $dbDefault;
    private $dbMain;

    private $tables;
    private static $limit = 1000;

    public function __construct() {
        parent::__construct();
        $this->dbDefault = ConnectionManager::getDataSource('default');
        $this->dbMain = ConnectionManager::getDataSource('main');
        ClassRegistry::init('AppModel');
        $this->tables = AppModel::getTables();
    }

    /*
     * Importowanie tabel z bazy main do default
     */
    public function import() {
        foreach($this->tables as $table) {
            $this->out($table);
            try {
                $this->dbDefault->execute('DROP TABLE `' . $table . '`');
            } catch(Exception $e) {
                $this->out($e->getMessage());
            }

            $file = TMP . $table . '.sql';
            $conf = $this->dbMain->config;
            exec('mysqldump -h '.$conf["host"].' -u '.$conf["login"].' --password=\''.$conf["password"].'\' --opt --where="1 limit '.self::$limit.'" '.$conf["database"].' '.$table.' > '.$file);
            $sql = file_get_contents($file);
            try {
                $this->dbDefault->execute($sql);
            } catch(Exception $e) {
                $this->out($e->getMessage());
            }

            unlink($file);
        }
    }

}