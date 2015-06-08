<?php

App::uses('AppModel', 'Model');

class UploadSessions extends AppModel {

    public $useTable = 'krakow_upload_sessions';

    public function createFromForm($data, $user_id) {
        $row = array(
            'hash' => uniqid(),
            'date' => $data['date'],
            'typ_id' => $data['typ_id'],
            'komisja_id' => $data['komisja_id'],
            'dzielnica_id' => $data['dzielnica_id'],
            'user_id' => $user_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        $label = 'Rada Miasta';

        if($data['typ_id'] == '2' && $data['komisja_id']) {
            $label = $this->getDataSource()->fetchAll("
                SELECT nazwa FROM rady_komisje WHERE id = ?
            ", array($data['komisja_id']))[0]['rady_komisje']['nazwa'];
        } else if($data['typ_id'] == '3' && $data['dzielnica_id']) {
            $label = $this->getDataSource()->fetchAll("
                SELECT nazwa FROM pl_dzielnice WHERE id = ?
            ", array($data['dzielnica_id']))[0]['pl_dzielnice']['nazwa'];
        }

        $row['label'] = $label;

        $this->create();
        $this->save($row);

        return array(
            'success' => true,
            'id' => $this->getLastInsertID()
        );
    }

}