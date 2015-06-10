<?php

require ROOT . DS . 'app/Lib/S3.php';

class S3Controller extends AppController {

    private static $lifetime = 60;

    private static $fields = array(
        'bucket',
        'uri'
    );

    public function getAuthenticatedURL() {
        foreach(self::$fields as $field)
            if(!isset($this->request->data[$field]))
                throw new BadRequestException;

        $s3 = new S3(
            Configure::read('S3.access_key'),
            Configure::read('S3.secret_key')
        );

        $s3->setEndpoint(
            Configure::read('S3.endpoint')
        );

        return $this->json(array(
            'url' => $s3->getAuthenticatedURL(
                $this->request->data['bucket'],
                $this->request->data['uri'],
                self::$lifetime
            )
        ));
    }

}