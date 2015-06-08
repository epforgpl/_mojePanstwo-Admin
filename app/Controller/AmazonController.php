<?php

class AmazonController extends AppController {

    public $components = array(
        'Amazon'
    );

    public $uses = array(
        'Krakow.UploadFiles'
    );

    public function signRequest() {
        $this->json(
            $this->Amazon->signRequest()
        );
    }

    public function download($id) {
        $file = $this->UploadFiles->findById($id);
        if(!$file)
            throw new NotFoundException;

        $this->redirect(
            $this->Amazon->getObjectUrl($file['UploadFiles']['key'])
        );
    }

}