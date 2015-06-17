<?php
/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 17/06/15
 * Time: 13:01
 */

class PrawoUrzedowe extends AnalyzersAppModel
{
    public $useTable = 'prawo_urzedowe';

    public function getInst()
    {
        return $this->query("SELECT id, nazwa FROM instytucje");
    }
}