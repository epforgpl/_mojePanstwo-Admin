<?php

class AmazonController extends AppController {

    public $components = array(
        'Amazon'
    );

    public function signRequest() {
        $this->json(
            $this->Amazon->signRequest()
        );
    }

}