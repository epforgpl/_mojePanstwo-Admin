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

        echo "WORKS!";

    }

    public function cleanUp()
    {
        $current_time = time();
        $three_days = 3 * 24 * 3600;

        $newer_than = $current_time - $three_days;

        $this->deleteAll(array(
            'AnalyzerExecution.completion_ts <' => date('Y-m-d H:i:s', $newer_than),
        ));

    }


}