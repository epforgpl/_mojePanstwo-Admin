<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 13:23
 */
class AnalyzerExecution extends AnalyzersAppModel
{
    public $useTable = 'analyzers_executions';
    public $hasOne = array(
        'analyzer_id' => array(
            'className' => 'Analyzers.Analyzer',
            'foreignKey' => 'analyzer_id',
        ),
    );
    public $actAs = array('Containable');
    public $uses = array('Analyzer');

    public function execute($id)
    {
        date_default_timezone_set('Europe/Warsaw');
        $starttime = microtime(true);

        $data = array();
        $time = time();
        $minusminute = date('Y-m-d H:i:s', $time - 60);
        $minushour = date('Y-m-d H:i:s', $time - 3600);
        $minusday = date('Y-m-d H:i:s', $time - 86400);

        $id = 'Indeksowanie';

        switch ($id) {

            case 'Krs': {

                $countM = $this->query("SELECT COUNT(*) as 'count' FROM krs_files WHERE `complete`='1' AND `complete_ts`>'$minusminute'");
                $countH = $this->query("SELECT COUNT(*) as 'count' FROM krs_files WHERE `complete`='1' AND `complete_ts`>'$minushour'");
                $countD = $this->query("SELECT COUNT(*) as 'count' FROM krs_files WHERE `complete`='1' AND `complete_ts`>'$minusday'");

                $msig_wydania = $this->query("SELECT data FROM msig_wydania ORDER BY data DESC LIMIT 1");

                $msig_con = $this->query("SELECT COUNT(*) AS 'count' , status  FROM msig_wydania GROUP BY status");
                $msig_con_last_err = $this->query("SELECT status, status_ts FROM msig_wydania WHERE status IN ('3','4') ORDER BY status_ts DESC LIMIT 1");
                $msig_con_last_corr = $this->query("SELECT status, status_ts FROM msig_wydania WHERE status='2' ORDER BY status_ts DESC LIMIT 1");

                $msig_proc = $this->query("SELECT COUNT(*) AS 'count', spis_analiza AS status FROM msig_wydania GROUP BY spis_analiza");
                $msig_proc_last_err = $this->query("SELECT spis_analiza, spis_analiza_ts FROM msig_wydania WHERE spis_analiza='4' ORDER BY spis_analiza_ts DESC LIMIT 1");
                $msig_proc_last_corr = $this->query("SELECT spis_analiza, spis_analiza_ts FROM msig_wydania WHERE spis_analiza='3' ORDER BY spis_analiza_ts DESC LIMIT 1");

                $msig_proc_d = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM msig_dzialy GROUP BY analiza");
                $msig_proc_d_last_err = $this->query("SELECT analiza, analiza_ts FROM msig_dzialy WHERE analiza IN ('4','5','6','7','8') ORDER BY analiza_ts DESC LIMIT 1");
                $msig_proc_d_last_corr = $this->query("SELECT analiza, analiza_ts FROM msig_dzialy WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $msig_proc_d_krs = $this->query("SELECT COUNT(*) AS 'count', process AS status FROM msig_dzialy GROUP BY process");
                $msig_proc_d_krs_last_err = $this->query("SELECT process, process_ts FROM msig_dzialy WHERE process IN ('4','5') ORDER BY process_ts DESC LIMIT 1");
                $msig_proc_d_krs_last_corr = $this->query("SELECT process, process_ts FROM msig_dzialy WHERE process='3' ORDER BY process_ts DESC LIMIT 1");

                $msig_next_proc_d_krs = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM msig_wpisy_kolejne GROUP BY analiza");
                $msig_next_proc_d_krs_last_err = $this->query("SELECT analiza, analiza_ts FROM msig_wpisy_kolejne WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $msig_next_proc_d_krs_last_corr = $this->query("SELECT analiza, analiza_ts FROM msig_wpisy_kolejne WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $krs_pos_chg = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM krs_pozycje_zmiany GROUP BY analiza");
                $krs_pos_chg_last_err = $this->query("SELECT analiza, analiza_ts FROM krs_pozycje_zmiany WHERE analiza='4' ORDER BY analiza_ts DESC LIMIT 1");
                $krs_pos_chg_last_corr = $this->query("SELECT analiza, analiza_ts FROM krs_pozycje_zmiany WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");


                $krs_new = $this->query("SELECT COUNT(*) AS 'count', status FROM krs_files GROUP BY status");
                $krs_new_last_err = $this->query("SELECT status, status_ts FROM krs_files WHERE status IN ('4','5','6') ORDER BY status_ts DESC LIMIT 1");
                $krs_new_last_corr = $this->query("SELECT status, status_ts FROM krs_files WHERE status='3' ORDER BY status_ts DESC LIMIT 1");

                $org_status = $this->query("SELECT COUNT( * ) AS  'count' , status FROM  krs_pozycje GROUP BY  status");
                $org_status_anl = $this->query("SELECT COUNT( * ) AS  'count' , analiza AS status FROM  krs_pozycje GROUP BY  analiza");
                $org_status_anl_intro = $this->query("SELECT COUNT( * ) AS  'count' , analiza_intro AS status FROM  krs_pozycje GROUP BY  analiza_intro");
                $org_status_anl_addr = $this->query("SELECT COUNT( * ) AS  'count' , analiza_adres AS status FROM  krs_pozycje GROUP BY  analiza_adres");
                $org_status_xml = $this->query("SELECT COUNT( * ) AS  'count' , xml AS status FROM  krs_pozycje GROUP BY  xml");


                $data = array(

                    'krs_downloads' => array(
                        'downloadM' => $countM[0][0]['count'],
                        'downloadH' => $countH[0][0]['count'],
                        'downloadD' => $countD[0][0]['count'],
                    ),

                    'krs_new' => $krs_new,
                    'krs_new_last_err' => $krs_new_last_err,
                    'krs_new_last_corr' => $krs_new_last_corr,

                    'org_status' => $org_status,
                    'org_status_xml' => $org_status_xml,
                    'org_status_anl_intro' => $org_status_anl_intro,
                    'org_status_anl_addr' => $org_status_anl_addr,
                    'org_status_anl' => $org_status_anl,

                    'msig_con' => $msig_con,
                    'msig_wydania' => $msig_wydania,
                    'msig_con_last_err' => $msig_con_last_err,
                    'msig_con_last_corr' => $msig_con_last_corr,

                    'msig_proc' => $msig_proc,
                    'msig_proc_last_err' => $msig_proc_last_err,
                    'msig_proc_last_corr' => $msig_proc_last_corr,

                    'msig_proc_d' => $msig_proc_d,
                    'msig_proc_d_last_err' => $msig_proc_d_last_err,
                    'msig_proc_d_last_corr' => $msig_proc_d_last_corr,

                    'msig_proc_d_krs' => $msig_proc_d_krs,
                    'msig_proc_d_krs_last_err' => $msig_proc_d_krs_last_err,
                    'msig_proc_d_krs_last_corr' => $msig_proc_d_krs_last_corr,

                    'msig_next_proc_d_krs' => $msig_next_proc_d_krs,
                    'msig_next_proc_d_krs_last_err' => $msig_next_proc_d_krs_last_err,
                    'msig_next_proc_d_krs_last_corr' => $msig_next_proc_d_krs_last_corr,

                    'krs_pos_chg' => $krs_pos_chg,
                    'krs_pos_chg_last_err' => $krs_pos_chg_last_err,
                    'krs_pos_chg_last_corr' => $krs_pos_chg_last_corr,
                );
                break;
            }
            case 'Prawo': {

                $ISAP_status = $this->query("SELECT COUNT(*) AS 'count', status FROM ISAP_pozycje GROUP BY status");
                $ISAP_status_last_err = $this->query("SELECT status, status_ts FROM ISAP_pozycje WHERE status IN ('4','5','6') ORDER BY status_ts DESC LIMIT 1");
                $ISAP_status_last_corr = $this->query("SELECT status, status_ts FROM ISAP_pozycje WHERE status='3' ORDER BY status_ts DESC LIMIT 1");

                $ISAP_analiza = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM ISAP_pozycje GROUP BY analiza");
                $ISAP_analiza_last_err = $this->query("SELECT analiza, analiza_ts FROM ISAP_pozycje WHERE analiza IN ('4','5','6','7','8') ORDER BY analiza_ts DESC LIMIT 1");
                $ISAP_analiza_last_corr = $this->query("SELECT analiza, analiza_ts FROM ISAP_pozycje WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $ISAP_analiza_isip = $this->query("SELECT COUNT(*) AS 'count', analiza_isip AS status FROM ISAP_pozycje GROUP BY analiza_isip");
                $ISAP_analiza_isip_last_err = $this->query("SELECT analiza_isip, analiza_isip_ts FROM ISAP_pozycje WHERE analiza_isip IN ('4','5','6','7','8') ORDER BY analiza_isip_ts DESC LIMIT 1");
                $ISAP_analiza_isip_last_corr = $this->query("SELECT analiza_isip, analiza_isip_ts FROM ISAP_pozycje WHERE analiza_isip='3' ORDER BY analiza_ts DESC LIMIT 1");


                $DzU_analiza = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM DzU_pozycje GROUP BY analiza");
                $DzU_analiza_last_err = $this->query("SELECT analiza, analiza_ts FROM DzU_pozycje WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $DzU_analiza_last_corr = $this->query("SELECT analiza, analiza_ts FROM DzU_pozycje WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");


                $MP_analiza = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM MP_pozycje GROUP BY analiza");
                $MP_analiza_last_err = $this->query("SELECT analiza, analiza_ts FROM MP_pozycje WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $MP_analiza_last_corr = $this->query("SELECT analiza, analiza_ts FROM MP_pozycje WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");


                $prawo_analiza = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM prawo GROUP BY analiza");
                $prawo_analiza_last_err = $this->query("SELECT analiza, analiza_ts FROM prawo WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $prawo_analiza_last_corr = $this->query("SELECT analiza, analiza_ts FROM prawo WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $prawo_analiza_status = $this->query("SELECT COUNT(*) AS 'count', analiza_status AS status FROM prawo GROUP BY analiza_status");
                $prawo_analiza_status_last_err = $this->query("SELECT analiza_status, analiza_status_ts FROM prawo WHERE analiza_status IN ('4','5','6') ORDER BY analiza_status_ts DESC LIMIT 1");
                $prawo_analiza_status_last_corr = $this->query("SELECT analiza_status, analiza_status_ts FROM prawo WHERE analiza_status='3' ORDER BY analiza_status_ts DESC LIMIT 1");

                $prawo_analiza_powiazania = $this->query("SELECT COUNT(*) AS 'count', analiza_powiazania AS status FROM prawo GROUP BY analiza_powiazania");
                $prawo_analiza_powiazania_last_err = $this->query("SELECT analiza_powiazania, analiza_powiazania_ts FROM prawo WHERE analiza_powiazania IN ('4','5','6') ORDER BY analiza_powiazania_ts DESC LIMIT 1");
                $prawo_analiza_powiazania_last_corr = $this->query("SELECT analiza_powiazania, analiza_powiazania_ts FROM prawo WHERE analiza_powiazania='3' ORDER BY analiza_powiazania_ts DESC LIMIT 1");


                $data = array(

                    'ISAP_status' => $ISAP_status,
                    'ISAP_status_last_err' => $ISAP_status_last_err,
                    'ISAP_status_last_corr' => $ISAP_status_last_corr,

                    'ISAP_analiza' => $ISAP_analiza,
                    'ISAP_analiza_last_err' => $ISAP_analiza_last_err,
                    'ISAP_analiza_last_corr' => $ISAP_analiza_last_corr,

                    'ISAP_analiza_isip' => $ISAP_analiza_isip,
                    'ISAP_analiza_isip_last_err' => $ISAP_analiza_isip_last_err,
                    'ISAP_analiza_isip_last_corr' => $ISAP_analiza_isip_last_corr,


                    'DzU_analiza' => $DzU_analiza,
                    'DzU_analiza_last_err' => $DzU_analiza_last_err,
                    'DzU_analiza_last_corr' => $DzU_analiza_last_corr,


                    'MP_analiza' => $MP_analiza,
                    'MP_analiza_last_err' => $MP_analiza_last_err,
                    'MP_analiza_last_corr' => $MP_analiza_last_corr,


                    'prawo_analiza' => $prawo_analiza,
                    'prawo_analiza_last_err' => $prawo_analiza_last_err,
                    'prawo_analiza_last_corr' => $prawo_analiza_last_corr,

                    'prawo_analiza_status' => $prawo_analiza_status,
                    'prawo_analiza_status_last_err' => $prawo_analiza_status_last_err,
                    'prawo_analiza_status_last_corr' => $prawo_analiza_status_last_corr,

                    'prawo_analiza_powiazania' => $prawo_analiza_powiazania,
                    'prawo_analiza_powiazania_last_err' => $prawo_analiza_powiazania_last_err,
                    'prawo_analiza_powiazania_last_corr' => $prawo_analiza_powiazania_last_corr,

                );
                break;
            }
            case 'Zamowienia Publiczne': {

                $uzp_dokumenty = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM uzp_dokumenty GROUP BY analiza");
                $uzp_dokumenty_last_err = $this->query("SELECT analiza, analiza_ts FROM uzp_dokumenty WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $uzp_dokumenty_last_corr = $this->query("SELECT analiza, analiza_ts FROM uzp_dokumenty WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $uzp_wykonawcy = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM uzp_wykonawcy GROUP BY analiza");
                $uzp_wykonawcy_last_err = $this->query("SELECT analiza, analiza_ts FROM uzp_wykonawcy WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $uzp_wykonawcy_last_corr = $this->query("SELECT analiza, analiza_ts FROM uzp_wykonawcy WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $uzp_zamawiajacy = $this->query("SELECT COUNT(*) AS 'count', analiza AS status FROM uzp_zamawiajacy GROUP BY analiza");
                $uzp_zamawiajacy_last_err = $this->query("SELECT analiza, analiza_ts FROM uzp_zamawiajacy WHERE analiza IN ('4','5','6') ORDER BY analiza_ts DESC LIMIT 1");
                $uzp_zamawiajacy_last_corr = $this->query("SELECT analiza, analiza_ts FROM uzp_zamawiajacy WHERE analiza='3' ORDER BY analiza_ts DESC LIMIT 1");

                $data = array(
                    'uzp_dokumenty' => $uzp_dokumenty,
                    'uzp_dokumenty_last_err' => $uzp_dokumenty_last_err,
                    'uzp_dokumenty_last_corr' => $uzp_dokumenty_last_corr,

                    'uzp_wykonawcy' => $uzp_wykonawcy,
                    'uzp_wykonawcy_last_err' => $uzp_wykonawcy_last_err,
                    'uzp_wykonawcy_last_corr' => $uzp_wykonawcy_last_corr,

                    'uzp_zamawiajacy' => $uzp_zamawiajacy,
                    'uzp_zamawiajacy_last_err' => $uzp_zamawiajacy_last_err,
                    'uzp_zamawiajacy_last_corr' => $uzp_zamawiajacy_last_corr,
                );
                break;
            }
            case 'Indeksowanie' : {
                $nazwy = $this->query("SELECT id, name, base_alias FROM api_datasets");
                $wartosci = $this->query("SELECT dataset, a, COUNT(*) AS 'count' FROM objects GROUP BY dataset, a");
                //        $date = $this->query("SELECT dataset_id, date, id FROM objects ");

                $nazwa = array();
                foreach ($nazwy as $key => $val) {
                    $nazwa[$val['api_datasets']['base_alias']] = array(
                        'name' => $val['api_datasets']['name'],
                        'id' => $val['api_datasets']['id']
                    );
                }
                $wartosc = array();
                foreach ($wartosci as $key => $val) {
                    if ($val['objects']['dataset'] != '') {
                        if (!isset($val['objects']['dataset'])) {
                            $wartosc[$val['objects']['dataset']] = array();
                        }
                        $wartosc[$val['objects']['dataset']][$val['objects']['a']] = $val[0]['count'];
                    }
                }
                debug($wartosc);
                $data = array(
                    'nazwy' => $nazwa,
                    'wartosci' => $wartosc,
                );
                break;
            }
            case 'Cluster' : {
                $cluster = $this->query("SELECT server_name, space_free, space_usage, avg1, insert_ts FROM watcher_log WHERE insert_ts>'$minushour' ORDER BY server_name, insert_ts ASC");

                $Portal = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $MySQL = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $Main = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $CPU_HOG = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $Video = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $ES1 = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $ES2 = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $ES3 = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];
                $ES4 = ['avg1' => [], 'space_free' => [], 'space_usage' => [], 'insert_ts' => []];

                foreach ($cluster as $key => $val) {
                    switch ($val['watcher_log']['server_name']) {
                        case 'Portal': {
                            $Portal['avg1'][] = $val['watcher_log']['avg1'];
                            $Portal['space_free'][] = $val['watcher_log']['space_free'];
                            $Portal['space_usage'][] = $val['watcher_log']['space_usage'];
                            $Portal['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'MySQL': {
                            $MySQL['avg1'][] = $val['watcher_log']['avg1'];
                            $MySQL['space_free'][] = $val['watcher_log']['space_free'];
                            $MySQL['space_usage'][] = $val['watcher_log']['space_usage'];
                            $MySQL['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'Main': {
                            $Main['avg1'][] = $val['watcher_log']['avg1'];
                            $Main['space_free'][] = $val['watcher_log']['space_free'];
                            $Main['space_usage'][] = $val['watcher_log']['space_usage'];
                            $Main['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'CPU-HOG': {
                            $CPU_HOG['avg1'][] = $val['watcher_log']['avg1'];
                            $CPU_HOG['space_free'][] = $val['watcher_log']['space_free'];
                            $CPU_HOG['space_usage'][] = $val['watcher_log']['space_usage'];
                            $CPU_HOG['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'video': {
                            $Video['avg1'][] = $val['watcher_log']['avg1'];
                            $Video['space_free'][] = $val['watcher_log']['space_free'];
                            $Video['space_usage'][] = $val['watcher_log']['space_usage'];
                            $Video['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'ES1': {
                            $ES1['avg1'][] = $val['watcher_log']['avg1'];
                            $ES1['space_free'][] = $val['watcher_log']['space_free'];
                            $ES1['space_usage'][] = $val['watcher_log']['space_usage'];
                            $ES1['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'ES2': {
                            $ES2['avg1'][] = $val['watcher_log']['avg1'];
                            $ES2['space_free'][] = $val['watcher_log']['space_free'];
                            $ES2['space_usage'][] = $val['watcher_log']['space_usage'];
                            $ES2['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'ES3': {
                            $ES3['avg1'][] = $val['watcher_log']['avg1'];
                            $ES3['space_free'][] = $val['watcher_log']['space_free'];
                            $ES3['space_usage'][] = $val['watcher_log']['space_usage'];
                            $ES3['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                        case 'ES4': {
                            $ES4['avg1'][] = $val['watcher_log']['avg1'];
                            $ES4['space_free'][] = $val['watcher_log']['space_free'];
                            $ES4['space_usage'][] = $val['watcher_log']['space_usage'];
                            $ES4['insert_ts'][] = $val['watcher_log']['insert_ts'];
                            break;
                        }
                    }
                }
                $data = array(
                    'Portal' => $Portal,
                    'MySQL' => $MySQL,
                    'Main' => $Main,
                    'CPU-HOG' => $CPU_HOG,
                    'Video' => $Video,
                    'ES1' => $ES1,
                    'ES2' => $ES2,
                    'ES3' => $ES3,
                    'ES4' => $ES4
                );
                break;
            }

            case 'BDL' : {
                $BDL_kategorie_status = $this->query("SELECT COUNT(*) AS 'count', status  FROM BDL_kategorie GROUP BY status");

                $BDL_kategorie_status_s = $this->query("SELECT COUNT(*) AS 'count', status_s AS status  FROM BDL_kategorie GROUP BY status_s");

                $BDL_grupy_status = $this->query("SELECT COUNT(*) AS 'count', status  FROM BDL_grupy GROUP BY status");

                $BDL_grupy_status_s = $this->query("SELECT COUNT(*) AS 'count', status_s AS status  FROM BDL_grupy GROUP BY status_s");

                $BDL_podgrupy_status = $this->query("SELECT COUNT(*) AS 'count', status  FROM BDL_podgrupy GROUP BY status");

                $BDL_podgrupy_status_s = $this->query("SELECT COUNT(*) AS 'count', status_s AS status  FROM BDL_podgrupy GROUP BY status_s");


                $data = array(
                    'BDL_kategorie_status' => $BDL_kategorie_status,
                    'BDL_kategorie_status_ts' => $BDL_kategorie_status_ts,
                    'BDL_kategorie_status_s' => $BDL_kategorie_status_s,
                    'BDL_kategorie_status_ts' => $BDL_kategorie_status_s_ts,

                );
                break;
            }

        }

        $endtime = microtime(true);

        return array(
            'data' => $data,
            'completition_duration' => $endtime - $starttime,
            'completition_ts' => date('Y-m-d H:i:s'),
            'analyzer_id' => $id,
        );
    }

    public function executeSave($id)
    {
        $data = $this->execute($id);
        $data['data'] = json_encode($data['data']);

        $this->create();
        $this->save($data, false);

        App::import('Analyzer');
        $analyzer = new Analyzer;
        $analyzer->save(array(
            'id' => $id,
            'execution_id' => $this->id,
            'execution_ts' => $data['completition_ts'],
        ));
        echo "$id ";
    }

    public function cleanUp()
    {
        date_default_timezone_set('Europe/Warsaw');
        $current_time = time();
        $three_days = 3 * 24 * 3600;

        $newer_than = $current_time - $three_days;

        $this->deleteAll(array(
            'AnalyzerExecution.completition_ts <' => date('Y-m-d H:i:s', $newer_than),
        ), false);
    }

    public function spaceCheck()
    {
        date_default_timezone_set('Europe/Warsaw');

        $time = time();
        $minus3minutes = date('Y-m-d H:i:s', $time - 180);

        $pamiec = $this->query("SELECT server_name, space_free FROM watcher_log WHERE space_free<0.1 AND insert_ts>'$minus3minutes' GROUP BY server_name");
        echo "Query done. ";
        if (sizeof($pamiec) != 0) {
            $Tresc = "Uwaga wymienione serwery mają poniżej 10% wolnego miejsca na dysku:
";
            foreach ($pamiec as $key => $val) {
                $Tresc .= "         {$val['watcher_log']['server_name']}: {$val['watcher_log']['space_free']}
";
            }
            $Email = new CakeEmail();
            $Email->from(array('no-reply@mojepanstwo.pl' => 'MojePanstwo.pl'));
            $Email->to('daniel.macuszyn@epf.org.pl');
            $Email->subject('[SERVER ALERT] Low disk space');
            $Email->send($Tresc . "Mail wysłany automatycznie");
            echo "Sent! ";
        }
    }

    public function reportCheck()
    {
        date_default_timezone_set('Europe/Warsaw');

        $time = time();
        $minus3minutes = date('Y-m-d H:i:s', $time - 180);

        $raport = $this->query("SELECT server_name FROM watcher_log WHERE server_name NOT IN (SELECT server_name FROM watcher_log WHERE insert_ts>'$minus3minutes') GROUP BY server_name");
        echo "Query done. ";
        if (sizeof($raport) != 0) {
            $Tresc = "Uwaga wymienione serwery nie wysłały raportu w ciągu ostatnich 3 minut:

";
            foreach ($raport as $key => $val) {
                $Tresc .= "         {$val['watcher_log']['server_name']}

";
            }
            $Email = new CakeEmail();
            $Email->from(array('no-reply@mojepanstwo.pl' => 'MojePanstwo.pl'));
            $Email->to('daniel.macuszyn@epf.org.pl');
            $Email->subject('[SERVER ALERT] No Report');
            $Email->send($Tresc);
            echo "Sent! ";
        }
    }

    public function cleanUpReports($days = 30)
    {
        date_default_timezone_set('Europe/Warsaw');
        $current_time = time();
        $minusdays = $days * 24 * 3600;

        $newer_than = $current_time - $minusdays;

        $this->query("DELETE FROM watcher_log where insertion_ts<date('Y-m-d H:i:s', $newer_than)");
    }
}