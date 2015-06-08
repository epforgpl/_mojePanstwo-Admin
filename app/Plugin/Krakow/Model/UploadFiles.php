<?php

App::uses('AppModel', 'Model');

class UploadFiles extends AppModel {

    public $useTable = 'krakow_upload_files';

    private static $labels = array(
        array(
            'Oczekuje',
            'muted'
        ),
        array(
            'W kolejce',
            'primary'
        ),
        array(
            'Przetwarzanie',
            'warning'
        ),
        array(
            'OK',
            'success'
        ),
        array(
            'Błąd',
            'danger'
        )
    );

    /**
     * Pobiera liste plików łączenie z danymi
     * z tabeli rady_posiedzenia_pliki oraz
     * etykietami statusów.
     *
     * @param $session_id int
     */
    public function getFiles($session_id) {
        $files = $this->getDataSource()->fetchAll(
            "
              SELECT *
              FROM krakow_upload_files
                LEFT JOIN rady_posiedzenia_pliki
                  ON rady_posiedzenia_pliki.id = krakow_upload_files.plik_id
              WHERE krakow_upload_files.session_id = ?
              ORDER BY krakow_upload_files.id
            ",
            array($session_id)
        );

        foreach($files as $i => $file) {
            $files[$i]['rady_posiedzenia_pliki']['preview_label'] = $this->getLabel(
                $file['rady_posiedzenia_pliki']['preview_status']
            );

            $files[$i]['rady_posiedzenia_pliki']['mpg_label'] = $this->getLabel(
                $file['rady_posiedzenia_pliki']['mpg_status']
            );
        }

        return $files;
    }

    private function getLabel($status = 0) {
        $i = (int) $status;
        return isset(self::$labels[$i]) ? self::$labels[$i] : self::$labels[4];
    }

}