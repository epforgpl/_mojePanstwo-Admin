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
        $url = $this->strategy['authorization_code_url'];
        $params = array(
            'redirect_uri'  => $this->strategy['redirect_uri'],
            'response_type' => $this->strategy['response_type'],
            'client_id'     => $this->strategy['client_id']
        );

        $this->clientGet($url, $params);
    }

    /**
     * Internal callback
     */
    public function int_callback() {
        if(array_key_exists('code', $_GET) && !empty($_GET['code'])) {
            $url = $this->strategy['access_token_url'];
            $params = array(
                'client_id' => $this->strategy['client_id'],
                'client_secret' => $this->strategy['client_secret'],
                'code' => trim($_GET['code']),
                'grant_type' => 'authorization_code'
            );

            $response = $this->serverGet($url, $params, null, $headers);
            $results = json_decode($response, 1);

            if (!empty($results) && !empty($results['access_token'])) {
                $me = $this->userinfo($results['access_token']);

                $this->auth = array(
                    'provider' => 'MojePanstwo',
                    'uid' => $me->id,
                    'info' => array(
                        'name' => $me->username,
                        //'image' => 'https://graph.facebook.com/'.$me->id.'/picture?type=square'
                    ),
                    'credentials' => array(
                        'token' => $results['access_token'],
                        'expires' => date('c', time() + $results['expires_in'])
                    ),
                    'raw' => $me
                );

                if (!empty($me->email)) $this->auth['info']['email'] = $me->email;
                if (!empty($me->username)) $this->auth['info']['nickname'] = $me->username;
                if (!empty($me->group_id)) $this->auth['info']['group_id'] = $me->group_id;
                //if (!empty($me->last_name)) $this->auth['info']['last_name'] = $me->last_name;
                //if (!empty($me->location)) $this->auth['info']['location'] = $me->location->name;
                //if (!empty($me->link)) $this->auth['info']['urls']['facebook'] = $me->link;
                //if (!empty($me->website)) $this->auth['info']['urls']['website'] = $me->website;

                /**
                 * Missing optional info values
                 * - description
                 * - phone: not accessible via Facebook Graph API
                 */

                $this->callback();
            } else {
                $error = array(
                    'provider' => 'MojePanstwo',
                    'code' => 'access_token_error',
                    'message' => 'Failed when attempting to obtain access token',
                    'raw' => $headers
                );
                $this->errorCallback($error);
            }
        } else {
            $error = array(
                'provider' => 'MojePanstwo',
                'code' => $_GET['error'],
                'message' => $_GET['error_description'],
                'raw' => $_GET
            );

            $this->errorCallback($error);
        }
    }

    private function userinfo($access_token) {
        $me = $this->serverGet($this->strategy['userinfo_url'], array('access_token' => $access_token), null, $headers);
        if (!empty($me)){
            return json_decode($me);
        }
        else{
            $error = array(
                'provider' => 'MojePanstwo',
                'code' => 'me_error',
                'message' => 'Failed when attempting to query for user information',
                'raw' => array(
                    'response' => $me,
                    'headers' => $headers
                )
            );
            $this->errorCallback($error);
        }
    }

}