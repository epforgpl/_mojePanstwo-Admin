<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 17/06/15
 * Time: 11:49
 */

class PrawoLokalne extends AnalyzersAppModel
{
    public $useTable = 'prawo_wojewodztwa';

    public function getWoj(){
        return $this->query("SELECT id, nazwa FROM wojewodztwa");
    }

    public function getGmi(){
        return $this->query("SELECT id, nazwa FROM gminy");
    }

}