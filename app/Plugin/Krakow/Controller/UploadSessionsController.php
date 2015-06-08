<?php

class UploadSessionsController extends KrakowAppController {

    public $components = array('Paginator');

    public $uses = array(
        'Krakow.Komisje',
        'Krakow.Dzielnice',
        'Krakow.UploadSessions',
        'Krakow.UploadFiles',
        'PLText',
        'Paginator'
    );

    private static $labels = array(
        'videojoin' => array(
            '1' => array('W kolejce', 'primary'),
            '2' => array('Przetwarzane', 'warning'),
            '3' => array('OK', 'success'),
            '4' => array('Brak sesji', 'danger'),
            '5' => array('Przetwarzanie', 'warning'),
            '6' => array('Przetwarzanie', 'warning')
        ),
        'videoyt' => array(
            '1' => array('W kolejce', 'primary'),
            '2' => array('Przetwarzane', 'warning'),
            '3' => array('OK', 'success'),
            '4' => array('Brak pliku', 'danger'),
            '5' => array('Błąd (5)', 'warning'),
            '6' => array('Błąd (6)', 'warning'),
            '9' => array('Błąd (9)', 'warning')
        ),
        'videopreview' => array(
            '1' => array('W kolejce', 'primary'),
            '2' => array('Przetwarzane', 'warning'),
            '3' => array('OK', 'success'),
            '4' => array('Brak pliku', 'danger'),
            '5' => array('Przetwarzanie plików (5)', 'warning'),
            '6' => array('Przetwarzanie plików (6)', 'warning'),
            '7' => array('Przetwarzanie plików (7)', 'warning'),
            '8' => array('Przetwarzanie plików (8)', 'warning'),
            '9' => array('Przetwarzanie plików (9)', 'warning'),
            '10' => array('Przetwarzanie plików (10)', 'warning'),
        ),
    );

    public function index() {
        $conditions = array();
        if(!isset($this->params['url']['all']))
            $conditions = array('user_id' => $this->Auth->user('id'));

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'UploadSessions' => array(
                'fields' => array(
                    'UploadSessions.*',
                    'UploadFiles.*',
                    'RadyPosiedzeniaPliki.*',
                    'PlGminyKrakowPosiedzenia.*',
                    'RadyKomisjePosiedzenia.*',
                    'RadyDzielnicePosiedzenia.*',
                    'PlGminyKrakowDzielniceRadyPosiedzenia.*'
                ),
                'limit' => 25,
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'krakow_upload_files',
                        'alias' => 'UploadFiles',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'UploadFiles.session_id = UploadSessions.id'
                        )
                    ),
                    array(
                        'table' => 'rady_posiedzenia_pliki',
                        'alias' => 'RadyPosiedzeniaPliki',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'RadyPosiedzeniaPliki.id = UploadFiles.plik_id'
                        )
                    ),
                    array(
                        'table' => 'pl_gminy_krakow_posiedzenia',
                        'alias' => 'PlGminyKrakowPosiedzenia',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'PlGminyKrakowPosiedzenia.folder_id = RadyPosiedzeniaPliki.posiedzenie_id'
                        )
                    ),
                    array(
                        'table' => 'rady_komisje_posiedzenia',
                        'alias' => 'RadyKomisjePosiedzenia',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'RadyKomisjePosiedzenia.upload_session_id = UploadSessions.id'
                        )
                    ),
                    array(
                        'table' => 'rady_dzielnice_posiedzenia',
                        'alias' => 'RadyDzielnicePosiedzenia',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'RadyDzielnicePosiedzenia.id = RadyPosiedzeniaPliki.posiedzenie_id'
                        )
                    ),
                    array(
                        'table' => 'pl_gminy_krakow_dzielnice_rady_posiedzenia',
                        'alias' => 'PlGminyKrakowDzielniceRadyPosiedzenia',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'PlGminyKrakowDzielniceRadyPosiedzenia.dzielnica_id = RadyDzielnicePosiedzenia.dzielnica_id',
                            'RadyDzielnicePosiedzenia.date = PlGminyKrakowDzielniceRadyPosiedzenia.data'
                        )
                    )
                ),
                'group' => array(
                    'RadyPosiedzeniaPliki.target_id',
                    'RadyPosiedzeniaPliki.subtarget_id',
                    'RadyPosiedzeniaPliki.posiedzenie_id'
                ),
                'order' => 'RadyPosiedzeniaPliki.cts DESC'
            )
        );

        $data = $this->Paginator->paginate('UploadSessions');
        $this->set('data', $data);
        $this->set('labels', self::$labels);
    }

    public function addForm() {
        if(isset($this->data) && is_array($this->data) && count($this->data) > 0) {
            return $this->json(
                $this->UploadSessions->createFromForm($this->data, $this->Auth->user('id'))
            );
        }

        $komisje = $this->Komisje->find('all', array(
            'conditions' => array(
                'Komisje.kadencja_7' => '1'
            ),
            'order' => array(
                'Komisje.nazwa'
            ),
        ));

        $dzielnice = $this->Dzielnice->find('all', array(
            'conditions' => array(
                'Dzielnice.pl_gminy_id' => 903
            ),
            'order' => array(
                'Dzielnice.nazwa'
            ),
        ));

        $this->set('komisje', $komisje);
        $this->set('dzielnice', $dzielnice);
    }

    public function view($id) {
        $session = $this->UploadSessions->findById($id);
        if(!$session)
            throw new NotFoundException;

        $config = Configure::read('Amazonsdk.credentials');
        unset($config['secret']);

        $files = $this->UploadFiles->getFiles($id);

        $this->set('config', json_encode($config));
        $this->set('files', $files);
        $this->set('session', $session);
    }

    public function uploadSuccess($id) {
        $session = $this->UploadSessions->findById($id);
        if(!$session)
            throw new NotFoundException;

        $this->UploadFiles->create();
        $this->UploadFiles->save(array(
            'session_id' => $session['UploadSessions']['id'],
            'session_hash' => $session['UploadSessions']['hash'],
            'key' => $this->data['key'],
            'uuid' => $this->data['uuid'],
            'name' => $this->data['name'],
            'bucket' => $this->data['bucket'],
            'etag' => $this->data['etag'],
            'ip' => $_SERVER['REMOTE_ADDR']
        ));

        $count = $this->UploadFiles->find('count', array(
            'conditions' => array(
                'UploadFiles.session_id' => $session['UploadSessions']['id'],
            ),
        ));

        $this->UploadSessions->id = $session['UploadSessions']['id'];
        $this->UploadSessions->save(array(
            'files_count' => $count
        ));

        $this->json(array(
            'success' => true
        ));
    }

    public function finishSession($id) {
        $session = $this->UploadSessions->findById($id);
        if(!$session)
            throw new NotFoundException;

        $this->UploadSessions->read(null, $session['id']);
        $this->UploadSessions->set(array(
            'finish_ts = NOW()',
            'finished' => '1' // @todo sprawdzić czy zapisuje prawidłowo
        ));
        $this->UploadSessions->save();

        return $this->json(array(
            'success' => true
        ));
    }

}