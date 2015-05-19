<?php

App::uses('ConnectionManager', 'Model');

class DatabaseShell extends AppShell {

    private $dbDefault;
    private $dbMain;

    private $tables;
    private static $limit = 30;

    public function __construct() {
        parent::__construct();
        $this->dbDefault = ConnectionManager::getDataSource('default');
        $this->dbMain = ConnectionManager::getDataSource('main');
        ClassRegistry::init('AppModel');
        $this->tables = AppModel::getTables();
    }

    /**
     * Usuwanie danych
     */
    public function drop() {
        foreach($this->tables as $table) {
            $query = 'DROP TABLE `'.$table.'`';
            $this->dbDefault->execute($query);
        }
    }

    /**
     * Tworzenie schematu
     */
    public function schema() {
        $query = file_get_contents(APP . 'Console/Command/Resources/schema.sql');
        $results = $this->dbDefault->execute($query);
    }

    /**
     * Kopiowanie danych
     */
    public function copy() {
        $errors = array();
        foreach($this->tables as $table) {
            $results =  $this->dbMain->fetchAll('SELECT * from `'.$table.'` LIMIT ' . self::$limit);
            foreach($results as $row) {
                $row = $row[$table];
                $query = $this->_insertQuery($table, $row);
                try {
                    $this->dbDefault->execute($query);
                } catch(Exception $e) {
                    $this->out($e->getMessage());
                    $errors[] = $table;
                }
            }
        }

        foreach($errors as $table) {
            $results =  $this->dbMain->fetchAll('SELECT * from `'.$table.'` LIMIT ' . self::$limit);
            foreach($results as $row) {
                $row = $row[$table];
                $query = $this->_insertQuery($table, $row);
                try {
                    $this->dbDefault->execute($query);
                } catch(Exception $e) {
                    $this->out($e->getMessage());
                }
            }
        }
    }

    /**
     * Tworzenie zapytania INSERT
     *
     * @param $table
     * @param $row
     * @return string
     */
    private function _insertQuery($table, $row) {
        $query = 'INSERT INTO `'.$table.'` VALUES(';
        foreach($row as $field => $value)
            $query .= '"'.$value.'",';
        $query = substr($query, 0, -1);
        $query .= ')';
        return $query;
    }

}