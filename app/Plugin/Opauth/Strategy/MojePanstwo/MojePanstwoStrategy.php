<?php

class MojePanstwoStrategy extends OpauthStrategy {

    public $expects = array('client_id', 'client_secret');

    public $defaults = array(
        'redirect_uri' => '{complete_url_to_strategy}int_callback'
    );

    /**
     * Auth request
     */
    public function request() {
        $url = 'https://mojepanstwo.pl/oauth/authorize';
        $params = array(
            'client_id' => $this->strategy['client_id'],
            'client_secret' => $this->strategy['client_secret']
        );

        if (!empty($this->strategy['scope'])) $params['scope'] = $this->strategy['scope'];
        if (!empty($this->strategy['state'])) $params['state'] = $this->strategy['state'];
        if (!empty($this->strategy['response_type'])) $params['response_type'] = $this->strategy['response_type'];
        if (!empty($this->strategy['display'])) $params['display'] = $this->strategy['display'];
        if (!empty($this->strategy['auth_type'])) $params['auth_type'] = $this->strategy['auth_type'];

        $this->clientGet($url, $params);
    }

    /**
     * Internal callback
     */
    public function int_callback() {
        debug($this->data);
    }

}