<?php

App::uses('ConnectionManager', 'Model');

class DatabaseShell extends AppShell {

    private $dbDefault;
    private $dbMain;

    private $local;

    private $tables;
    private static $limit = 1000;

    public function __construct() {
        parent::__construct();
        ClassRegistry::init('AppModel');
        $this->local = AppModel::$local;
        $this->tables = AppModel::getTables();

        if($this->local) {
            $this->dbDefault = ConnectionManager::getDataSource('default');
            $this->dbMain = ConnectionManager::getDataSource('main');
        }
    }

    /*
     * Importowanie tabel z bazy main do default
     */
    public function import() {
        if(!$this->local) {
            $this->out('Project does not use local database.');
            $this->out('To import tables change local database settings in app/Config/database.php');
            $this->out('Next set `Database.local` in app/Config/core.php to true');
            return false;
        }

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