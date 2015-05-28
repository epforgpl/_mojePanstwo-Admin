<?php

App::uses('AppModel', 'Model');

class Punkty extends AppModel {

    public $useTable = 'pl_gminy_krakow_posiedzenia_punkty';

    public function getPlan($date) {
        return $this->getDataSource()->fetchAll(
            'SELECT id, nr, tytul FROM pl_gminy_krakow_posiedzenia_punkty_plan WHERE posiedzenie_data = ? ORDER BY nr ASC',
            array(addslashes($date))
        );
    }

    public function saveData($id, $data) {
        $item = $this->getDataSource()->fetchAll("SELECT id, posiedzenie_id, ord, nr, tytul, czas_start, czas_stop, start_file_id, start_time, stop_file_id, stop_time, wystapienia_akcept FROM pl_gminy_krakow_posiedzenia_punkty WHERE id = ?", array($id));

        if(!isset($item[0]['pl_gminy_krakow_posiedzenia_punkty']))
            return false;

        $item = $item[0]['pl_gminy_krakow_posiedzenia_punkty'];
        $item = array_merge($item, array(
            'start_file_id' => (int) $item['start_file_id'],
            'start_time' => (float) $item['start_time'],
            'stop_file_id' => (int) $item['stop_file_id'],
            'stop_time' => (float) $item['stop_time'],
        ));

        $db_item = array(
            'id' => $id,
            'czas_akcept' => '1',
            'wystapienia_akcept' => addslashes( '1' ),
            'start_file_id' => (int) $data['start']['file_id'],
            'start_time' => (float) $data['start']['time'],
            'stop_file_id' => (int) $data['stop']['file_id'],
            'stop_time' => (float) $data['stop']['time'],
            'tytul' => $data['title'],
            'opis' => $data['desc'],
            'analiza' => '1',
            'analiza_ts' => 'NOW()',
        );

        if( $item['start_file_id']!=$db_item['start_file_id'] ||
            $item['start_time']!=$db_item['start_time'] ||
            $item['stop_file_id']!=$db_item['stop_file_id'] ||
            $item['stop_time']!=$db_item['stop_time'] ) {
            $db_item = array_merge($db_item, array(
                'video' => '1',
            ));
        }

        return $this->save($db_item);
    }

    public function getData($id) {
        $result = array();
        $item = $this->getDataSource()->fetchAll("
            SELECT
                pl_gminy_krakow_posiedzenia_punkty.id,
                pl_gminy_krakow_posiedzenia_punkty.posiedzenie_id,
                pl_gminy_krakow_posiedzenia_punkty.ord,
                pl_gminy_krakow_posiedzenia_punkty.ord_panel,
                pl_gminy_krakow_posiedzenia_punkty.nr,
                pl_gminy_krakow_posiedzenia_punkty.tytul,
                pl_gminy_krakow_posiedzenia_punkty.opis,
                pl_gminy_krakow_posiedzenia_punkty.czas_str,
                pl_gminy_krakow_posiedzenia_punkty.czas_start,
                pl_gminy_krakow_posiedzenia_punkty.czas_start_arkusz,
                pl_gminy_krakow_posiedzenia_punkty.czas_stop,
                pl_gminy_krakow_posiedzenia_punkty.czas_stop_arkusz,
                pl_gminy_krakow_posiedzenia_punkty.start_file_id,
                pl_gminy_krakow_posiedzenia_punkty.start_time,
                pl_gminy_krakow_posiedzenia_punkty.stop_file_id,
                pl_gminy_krakow_posiedzenia_punkty.stop_time,
                pl_gminy_krakow_posiedzenia_punkty.wystapienia_akcept,
                pl_gminy_krakow_posiedzenia_punkty.czas_akcept,
                pl_gminy_krakow_posiedzenia.date as 'posiedzenie_data',
                pl_gminy_krakow_posiedzenia.folder_id,
                rady_druki.numer as 'druk_numer'
            FROM pl_gminy_krakow_posiedzenia_punkty
            JOIN pl_gminy_krakow_posiedzenia
                ON pl_gminy_krakow_posiedzenia_punkty.posiedzenie_id = pl_gminy_krakow_posiedzenia.id
            LEFT JOIN rady_druki
                ON pl_gminy_krakow_posiedzenia_punkty.druk_id = rady_druki.id
            WHERE pl_gminy_krakow_posiedzenia_punkty.id = ?
            LIMIT 1
        ", array($id));

        $item = $item[0];
        $r = array();
        foreach($item as $values)
            $r = array_merge($r, $values);
        $item = $r;

        if( $item['czas_akcept']!='1' )
            $item = array_merge($item, array(
                'czas_start' => $item['czas_start_arkusz'],
                'czas_stop' => $item['czas_stop_arkusz'],
            ));

        $czas_start = 0;
        $czas_start_m = 1;
        $item['czas_str'] = str_replace('.', ':', $item['czas_str']);
        $czas_start_parts = explode(':', $item['czas_str']);
        $item['czas_parts'] = $czas_start_parts;
        for( $i=count($czas_start_parts); $i--; $i>=0 ) {

            $c = (int) $czas_start_parts[ $i ];
            $czas_start += $czas_start_m * $c;
            $czas_start_m *= 60;

        }

        $item['czas'] = $czas_start;

        $wystapienia_count = $this->getDataSource()->fetchAll(
            'SELECT COUNT(*) FROM rady_posiedzenia_debaty_oznaczone_wystapienia WHERE punkt_id = ?',
            array($id)
        );

        $prev = $this->getDataSource()->fetchAll(
            'SELECT id, stop_file_id, stop_time FROM pl_gminy_krakow_posiedzenia_punkty WHERE `posiedzenie_id`= ? AND `ord_panel` < ? ORDER BY `ord_panel` DESC LIMIT 1',
            array($item['posiedzenie_id'], $item['ord_panel'])
        );

        $prev = @$prev[0];
        $r = array();
        foreach((array)@$prev as $values)
            $r = array_merge($r, $values);
        $prev = $r;

        $next = $this->getDataSource()->fetchAll(
            'SELECT pl_gminy_krakow_posiedzenia_punkty.id, pl_gminy_krakow_posiedzenia_punkty.nr, pl_gminy_krakow_posiedzenia_punkty.tytul, rady_druki.numer, pl_gminy_krakow_posiedzenia_punkty.czas_str FROM pl_gminy_krakow_posiedzenia_punkty LEFT JOIN rady_druki ON pl_gminy_krakow_posiedzenia_punkty.druk_id=rady_druki.id WHERE pl_gminy_krakow_posiedzenia_punkty.`posiedzenie_id` = ? AND pl_gminy_krakow_posiedzenia_punkty.`ord_panel` > ? ORDER BY pl_gminy_krakow_posiedzenia_punkty.`ord_panel` ASC LIMIT 1',
            array($item['posiedzenie_id'], $item['ord_panel'])
        );

        $next = @$next[0];
        $r = array();
        foreach(@(array) $next as $values)
            $r = array_merge($r, $values);
        $next = $r;

        $item = array_merge($item, array(
            'wystapienia_count' => $wystapienia_count[0][0]['COUNT(*)'],
            'prev' => $prev,
            'next' => $next
        ));

        if( $item['next'] && $item['next']['czas_str'] ) {

            $item['next']['czas_str'] = str_replace('.', ':', $item['next']['czas_str']);

            $czas_start = 0;
            $czas_start_m = 1;
            $czas_start_parts = explode(':', $item['next']['czas_str']);
            for( $i=count($czas_start_parts); $i--; $i>=0 ) {

                $c = (int) $czas_start_parts[ $i ];
                $czas_start += $czas_start_m * $c;
                $czas_start_m *= 60;

            }

            $item['next']['czas'] = $czas_start;

        }

        $upload_session = $this->getDataSource()->fetchAll(
            'SELECT id FROM krakow_upload_sessions WHERE typ_id = 1 AND date = ? ORDER BY id DESC LIMIT 1',
            array($item['posiedzenie_data'])
        );

        $upload_session = @$upload_session[0];
        $r = array();
        foreach(@(array) $upload_session as $values)
            $r = array_merge($r, $values);
        $upload_session = $r;

        if($upload_session)
            $pliki = $this->getDataSource()->fetchAll(
                'SELECT rady_posiedzenia_pliki.id, rady_posiedzenia_pliki.filename, rady_posiedzenia_pliki.dlugosc, rady_posiedzenia_pliki.posiedzenie_czas_start FROM rady_posiedzenia_pliki JOIN krakow_upload_files ON rady_posiedzenia_pliki.id=krakow_upload_files.plik_id WHERE rady_posiedzenia_pliki.target_id=1 AND krakow_upload_files.session_id = ? ORDER BY krakow_upload_files.name ASC',
                array($upload_session['id'])
            );
        else $pliki = array();

        $r = array();
        foreach($pliki as $values)
            $r[] = $values['rady_posiedzenia_pliki'];
        $pliki = $r;

        $result['item'] = $item;
        $result['pliki'] = $pliki;

        return $result;
    }

    public function findByIdWithClosest($id) {
        $punkt = $this->findById($id);
        if(!$punkt)
            return false;

        ClassRegistry::init('Krakow.RadyDruki');
        $RadyDruki = new RadyDruki();

        $punkt['RadyDruki'] = array();
        if($punkt['Punkty']['druk_id']) {
            $punkt['RadyDruki'] = $RadyDruki->find('first', array(
                'conditions' => array(
                    'RadyDruki.id >' => $punkt['Punkty']['druk_id']
                ),
            ));
        }

        $punktNext = $this->find('first', array(
            'fields' => array('id', 'nr', 'tytul', 'opis', 'czas_str', 'druk_id'),
            'conditions' => array(
                'Punkty.ord_panel >' => $punkt['Punkty']['ord_panel'],
                'Punkty.posiedzenie_id' => $punkt['Punkty']['posiedzenie_id']
            ),
            'order' => array(
                'Punkty.ord_panel' => 'asc'
            ),
        ));

        $punktNext['RadyDruki'] = array();
        if($punktNext['Punkty']['druk_id']) {
            $punktNext['RadyDruki'] = $RadyDruki->find('first', array(
                'conditions' => array(
                    'RadyDruki.id >' => $punktNext['Punkty']['druk_id']
                ),
            ));
        }

        $punktPrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'Punkty.ord_panel <' => $punkt['Punkty']['ord_panel'],
                'Punkty.posiedzenie_id' => $punkt['Punkty']['posiedzenie_id']
            ),
            'order' => array(
                'Punkty.ord_panel' => 'desc'
            ),
        ));

        $punkt['Punkty']['next'] = count($punktNext) > 0 ? $punktNext : false;
        $punkt['Punkty']['prev'] = count($punktPrev) > 0 ? $punktPrev : false;

        return $punkt;
    }

}