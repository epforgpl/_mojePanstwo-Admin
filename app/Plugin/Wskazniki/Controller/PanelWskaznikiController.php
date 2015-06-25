<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 19/06/15
 * Time: 13:24
 */
class PanelWskaznikiController extends WskaznikiAppController
{
    public $components = array('RequestHandler', 'Paginator');

    public $uses = array(
        'Wskazniki.BdlPodgrupy',
        'Wskazniki.PanelWskazniki',
        'Wskazniki.PanelWskaznikiBdlPodgrupy',
        'PLText',
        'Paginator'
    );

    public function index($search = 'all')
    {

        if (isset($this->params['url']['search'])) {
            $search = $this->params['url']['search'];
        }
        $conditions = array();

        if ($search !== 'all') {
            $conditions[] = "PanelWskazniki.nazwa LIKE '%$search%'";
        } else {
            $conditions[] = 1;
        }
        $conditions[] = "PanelWskazniki.deleted=0";

        $this->Paginator->settings = array(
            'paramType' => 'querystring',
            'PanelWskazniki' => array(
                'limit' => 25,
                'order' => array('id' => 'asc'),
                'fields' => array('id', 'tytul'),
                'conditions' => $conditions,
            )
        );
        $this->PanelWskazniki->contain();
        // $this->PanelWskazniki->bindModel(array('hasOne'=>array('Wskazniki.PanelWskaznikiBdlPodgrupy')));

        try {
            $data = $this->Paginator->paginate('PanelWskazniki');
        } catch (NotFoundException $e) {
            $this->redirect(array(
                'controller' => 'PanelWskazniki',
                'action' => 'index',
            ));
        }
        $this->set('data', $data);
    }

    public function edit($id = '')
    {
        if ($id !== '') {
            $data = $this->PanelWskazniki->find('first', array('id' => $id));
            if (!$data)
                throw new NotFoundException;

            $this->set('wskazniki', $data['PanelWskazniki']);
            $this->set('podgrupy', $data['BdlPodgrupy']);
        }
    }

    public function add()
    {

    }

    public function getdata()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($_POST['search'] == '') {
                $conditions = 1;
            } else {
                $conditions = 'BdlPodgrupy.tytul LIKE "%' . $_POST['search'] . '%"';
            }

            $this->BdlPodgrupy->contain();
            if ($data = $this->BdlPodgrupy->find('all', array(
                    'conditions' => $conditions,
                    'fields' => array('tytul', 'id'),
                    'limit' => 14
                )
            )
            ) {
                $this->json($data);
            } else {
                $this->json(false);
            }
            $this->autoRender = false;
        }
    }
    public function savedata()
    {
        $this->json(true);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $wskaznik = array();
            $podgrupy = array();

            $i = 0;
            if (isset($_POST['licznik'])) {
                foreach ($_POST['licznik'] as $key => $val) {

                    $znak = str_replace('znak=', '', $val);
                    $podgrupy[] = array(
                        'BDL_podgrupa_id' => $key,
                        'L_M' => 'licznik',
                        'P_N' => $znak,
                        'position' => $i
                    );
                    $i++;
                }
            }
            $i = 0;
            if (isset($_POST['mianownik'])) {
                foreach ($_POST['mianownik'] as $key => $val) {

                    $znak = str_replace('znak=', '', $val);
                    $podgrupy[] = array(
                        'BDL_podgrupa_id' => $key,
                        'L_M' => 'mianownik',
                        'P_N' => $znak,
                        'position' => $i
                    );
                    $i++;
                }
            }

            if ($_POST['id'] !== '') {
                $wskaznik['PanelWskazniki']['id'] = $_POST['id'];
            }

            $wskaznik['BdlPodgrupy'] = array('BdlPodgrupy' => $podgrupy);
            $wskaznik['PanelWskazniki']['tytul'] = $_POST['tytul'];
            $wskaznik['PanelWskazniki']['opis'] = $_POST['opis'];

            if ($this->PanelWskazniki->save($wskaznik)) {
                $this->json($this->PanelWskazniki->getLastInsertId());
            } else {
                $this->json(false);
            }
        }
        $this->autoRender = false;
    }

    public function import(){

    }

    public function saveimport(){
        //$this->PanelWskazniiki->useDbConfig = 'default';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if($_POST['tytul_skr']!==''){
                $table_name=trim($_POST['tytul_skr']);
                $table_name=preg_replace('/[^a-z0-9 -]+/', '', $table_name);
                $table_name=str_replace(' ','_',$table_name);
                $table_name=strtolower($table_name);
                //$this->PanelWskazniki->tableCreate($table_name);
            }else{
                $this->json('Nie podano nazwy skróconej');
                return;
            }

            if($_POST['url']!==''){
                $url=trim($_POST['url']);
                $url=str_replace('edit#', 'export?format=tsv&',$url);
                $url= filter_var($url, FILTER_SANITIZE_URL);

                //TODO: Poprawic na lepszego curla
                $curl_cmd="curl '$url' -H 'accept-encoding: gzip, deflate, sdch' -H 'accept-language: en-US,en;q=0.8' -H 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36' -H 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'authority: docs.google.com' -H 'cookie: S=apps-spreadsheets=1w_376meYImGUXJ7_SMzZA; GMAIL_RTT=82; HSID=ADWkrXVA8Pfl-AyGk; SSID=ABqNN2pDsVftbEkwO; APISID=EOWqdLibwYDvYt3O/A87W8e2LSKWCIt7u_; SAPISID=3ktWcUxtgQECQwW2/AAdaHHFYCzWQ46Rz8; PREF=ID=f32433e734be38f0:FF=0:TM=1434983560:LM=1434983560:GM=1:S=DbI2b8GV53l7PcJB; SID=DQAAALcBAAC9eIrJTXYlGMamHhdsHpboyhXGiatksRqdcGhp6l22Ha8ZNJnwWu91B0cAfCCqc9GscvsoPn-GtrbdKOU4OgB99UhOWU_v-xQlzNIA3cgjK-cKf4gxQA4MDfabYX_dYt6VWAaItyM_KGTv8LfZD0Mqg5ewqwzCS5bIZrlrTbBeIY4tgcLaEyclp5prxiXhkLh-k2WC3NHHyg0EjcERAwpbAyFB5ZQKv5wo-I2abO3zEpOaNz9dXDJKe1wZvPa39QU4Kx43bA9X1fNpks5jB1ACELdZZXlXxCDjX5H2RyFjlZoJhFua5bsIvuFdznJ3Vn1efWzmc5LWnunaUZqZVAwyPb149SrbwAaG3uTWFB92bCYz6fHk6EYJ6NtAtcpLyJZG6Lmg0tHYLzhQaZn_g2n7X9FENxtoiryY5zvyMCwmPdDtCK0Al1VFSXSolvlHbZJdawbNQERNl1A1bEwUv6oplC_PX1JHOkmPGGkId8vzTffxm2oNcYEyzLjjZsMoL9Z56MFQUtNFch4GaYvGJyxQWivogJi8EF5FwDCS9d6i87TJkaDo4mtSPIFtJi6CRcBy2f26kkeTXSy5E-2krexa; NID=68=ShThU-f3DdWfvIlmtFYqB-JCHJSCeG-4psl27lgHo4IUuH-uN8U7NMlX8hUFNo5pd1d90SMd3YGlg-LAV3QvtkjRrsTl40d_2btz2CEvpZ15rAzVZwuxOGjx7Fhfqy_TJ9NtrR-yPfrSzBJM_3lE; WRITELY_SID=DQAAALkBAACa6yISq1trt7bMjw55O5N4N4jXwNp9LE_T1-Mt28UJIRJFKtECcKQe4Ral62K-z0ZRFPypPrH132F9HvLotuFZjX5XCQ5rt2F1Wx8Tw7-baXZ69C_Lobu4RQ4_kLIIQbXS0vsYiB7GXbKTiLm-TmNf_EzCva7phhSyC9PeSb6FRdPhpFqsd0qXN0xNOx2Ii6nlwLRQPtYW7ciVk6hKOkQ7xqor76kBB1BmfNTk1Twck6pMR-h1OI2nPbRCah4T0P2Cc2y22wZ-7JY_q9udehPX6-2t8f242hDmMpDR6nhPvruIe2IYxTKCjbwvPtDXA0umz0NOmKxVjgj-wOfK8QPsAexgaxcGa4chAP0aYHq2LuQ7GExMKUbQTHG4Uyt_TYZw9MgeAf_T8fIw5DfFfXjJXm-t9r9qHpjHixODH6BzZ7EgCAt07tRnNyeVKeUhzXzPgMYorIvOEKnBLP9170DpeYJ7Wp0PN1u68_fQFKzBx_yZD0dfMI68TSgLaK0Du-0-BuzeKOmt62q4wFZgtTAEdX-gdb8WkptEZs6Yz7ANRJwU8xisrQqzml3Oo57zlbrg40hgmbq2RintvsCfsTfF; S=explorer=QMnBex6OVWdWF-qN8bNj7Q' --compressed";

                exec($curl_cmd,$tsv);
                $data=array();
                foreach($tsv as $row){
                    $data[]=preg_split("/[\t]/",$row,0, NULL);
                }

            }else{
                $this->json('Nie podano adresu skoroszytu');
                return;
            }
/*
            ;
*/


        }
        $this->autoRender = false;
    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_list = $_POST['delete_ids'];
            if (sizeof($id_list) == 1) {
                $this->PanelWskazniki->updateAll(
                    array('deleted' => "1"),
                    array("id" => $id_list[0])
                );
            } else {
                $this->PanelWskazniki->updateAll(
                    array('deleted' => "1"),
                    array("id IN" => $id_list)
                );
            }

            $this->json($id_list);
        } else {
            $this->json(false);
        }
        $this->autoRender = false;
    }
}