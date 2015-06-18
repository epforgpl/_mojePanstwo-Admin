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

    public function findByIdWithClosest($id)
    {
        $prawolokalne = $this->findById($id);
        if (!$prawolokalne)
            return false;

        $prawolokalnePrev = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                'PrawoLokalne.data_wydania <=' => $prawolokalne['PrawoLokalne']['data_wydania'],
                '(YEAR(data_wydania)>rocznik+1 OR data_wydania > CURDATE() ) AND data_poprawiona IS NULL',
                'PrawoLokalne.id !='=>$prawolokalne['PrawoLokalne']['id']
            ),
            'order' => array(
                'PrawoLokalne.data_wydania' => 'desc',
                'PrawoLokalne.id'=> 'asc'
            ),
        ));

        $prawolokalneNext = $this->find('first', array(
            'fields' => array('id'),
            'conditions' => array(
                '(YEAR(data_wydania)>rocznik+1 OR data_wydania > CURDATE()) AND data_poprawiona IS NULL',
                'PrawoLokalne.data_wydania >=' => $prawolokalne['PrawoLokalne']['data_wydania'],
                'PrawoLokalne.id !='=>$prawolokalne['PrawoLokalne']['id']
            ),
            'order' => array(
                'PrawoLokalne.data_wydania' => 'asc',
                'PrawoLokalne.id'=> 'desc'
            ),
        ));

        $prawolokalne['PrawoLokalne']['next'] = count($prawolokalneNext) > 0 ? $prawolokalneNext : false;
        $prawolokalne['PrawoLokalne']['prev'] = count($prawolokalnePrev) > 0 ? $prawolokalnePrev : false;

        return $prawolokalne;
    }

}