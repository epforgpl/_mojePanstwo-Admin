<?php

App::uses('AppHelper', 'View/Helper');

class AccessHelper extends AppHelper {

    public function has($group) {
        $user = AuthComponent::user();
        if(!is_array($group) && in_array($group, @$user['admin_groups']))
            return true;

        if(is_array($group)) {
            foreach($group as $g) {
                if(in_array($g, @$user['admin_groups']))
                    return true;
            }
        }

        return false;
    }

}