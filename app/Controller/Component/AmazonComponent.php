<?php

require ROOT . DS . 'vendor/autoload.php';
App::uses('Component', 'Controller');
use Aws\S3\S3Client;

class AmazonComponent extends Component {

    public function signRequest() {
        $client = S3Client::factory(array(
           'key'    => Configure::read('Amazonsdk.credentials.key'),
           'secret' => Configure::read('Amazonsdk.credentials.secret'),
           'region' => Configure::read('Amazonsdk.credentials.region')
        ));

        $postObject = new \Aws\S3\Model\PostObject($client, Configure::read('Amazonsdk.credentials.bucket'), array(
           'acl' => 'private',
           'success_action_status' => '^',
           'x-amz-meta-qqfilename' => '^',
           'Content-Type' => '^' // fix error with content-type
        ));

        $vars = $postObject->prepareData()->getFormInputs();

        return array(
           'policy' => $vars['policy'],
           'signature' => $vars['signature']
        );
    }

    public function getObjectUrl($key) {
        $client = S3Client::factory(array(
            'key'    => Configure::read('Amazonsdk.credentials.key'),
            'secret' => Configure::read('Amazonsdk.credentials.secret')
        ));

        return $client->getObjectUrl(Configure::read('Amazonsdk.credentials.bucket'), $key, '+3 hours');
    }

}