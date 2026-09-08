<?php

use phpseclib3\Net\SSH2;
use phpseclib3\Net\SFTP;

require_once('src/repository/CmsRepo.php');

class C_Batch
{
    // Scripts autorisés (whitelist de sécurité)
    private  $SCRIPTS = [
        'run_check_batchs'  => 'run-check-batchs.sh',
        'Cfechab'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/check-fechab.sh',
        'Sfechab'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/set-fechab.sh',
        'mra_cms_scp3'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/check/mra_cms_scp3.sh',
        'lecc300'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-lecc0300.sh',
        'lecc510' => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0510-log.sh',
        'lecc600'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0600-log.sh',
        'lecc540'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0540-log.sh',
        'calcsmo'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-calc_csmo-log.sh',
        'estimation'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-estimation-log.sh',
        'facc000'  => "/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-facc0001-log.sh",
        'os_anomalia'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-os_anomalias.sh',
        'campania'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-campania.sh',
        'cb_split'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb_split-log.sh',
        'cb_conv'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb_conv-log.sh',
        'cb_stprod'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb-stprod-log.sh',
        'cb_stext'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb-stext-log.sh',
        'depose_bt'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-upload-bills.sh',
        'depose_mt'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-upload-mv-bills.sh',
        'gen_bordereau'  => '/u02/VAS_APPS/BORDEREAU-FACTURATION/Extract-Bordereau-Facturation-NOC.sh',
        'check_bordereau'  => '/u02/VAS_APPS/BORDEREAU-FACTURATION/check-bordereau.sh',
        'lecc300_lecc540'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0300-540-log.sh',
        'facc_cb_prod'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-facturation-facc-to-cb_stprod-log.sh',
    ];

    private  $KILLS = [
        'mra_cms_scp3'  => 'mra_cms_scp3.sh',
        'lecc300'  => 'LECC0300',
        'lecc510' => 'LECC0510',
        'lecc600'  => 'LECC0600',
        'lecc540'  => 'LECC0540',
        'calcsmo'  => 'calc_csmo',
        'estimation'  => 'estimation',
        'facc000'  => "FACC0001",
        'os_anomalia'  => 'os_anomalias',
        'campania'  => 'campania',
        'cb_split'  => 'cb_split',
        'cb_conv'  => 'cb_conv',
        'cb_stprod'  => 'cb_stProd',
        'cb_stext'  => 'cb_stExt'
    ];

    private  $CHECKS = [
        'lecc510' => "select count(*) c from  ciclos_itin  where est_ciclo_itin='IR009'  order by num_itin",
        'lecc600'  => "select  count(*) c  from itiner_aus  where EST_LECT = 'EL003'",
        'lecc540'  => "select  count(*) c from ciclos_itin  where est_ciclo_itin='IR005'  order by num_itin",
        'calcsmo'  => "select  count(*) c from itifact where ind_tratado=2 and ind_embalsado=2 and f_actual>sysdate-30",
        'estimation'  => "select  count(*) c from sum_estimar where ind_tratado=2 and ind_embalsado=2 and f_actual>sysdate-30",
        'facc000'  => "select  count(*) c from serv_facturar where ind_fact=2 and ind_embalsado=2 and f_actual>sysdate-30",
        'cb_split'  => "select distinct  est_act,  count(*) over(partition by est_act) c from recibos_dispatch where f_actual>sysdate-30 AND est_act = 'ER010'",
        'cb_conv'  => "select distinct  est_act,  count(*) over(partition by est_act) c from recibos_dispatch where f_actual>sysdate-30 AND est_act = 'ER015'",
        'cb_stprod'  => "select distinct  est_imagen,  count(*) over(partition by est_imagen) c from imagenes_dispatch where  est_imagen  in ('PS001','PS002') and f_actual>sysdate-30 and est_imagen = 'PS001'",
        'cb_stext'  => "select distinct  est_imagen,  count(*) over(partition by est_imagen) c from imagenes_dispatch where  est_imagen  in ('PS001','PS002') and f_actual>sysdate-30 and est_imagen = 'PS002'",
        'nbr_facture'  => "with tmp as (
                            select /*+ parallel(8) */ b.nom_area as REGION,count(be.num_rec) as NBRE_FACTURE
                            from business_struct b
                            join bill_extraction_list be on b.cod_unicom = be.cod_unicom
                            where be.f_batch_date = date'2026-06-15'
                            group by b.nom_area
                            )
                            select sum( NBRE_FACTURE ) c from tmp"
    ];

    public function __construct()
    {
        CheckUserConnect();
    }

    function default()
    {
        require('template/batch.php');
    }

    function batch_mt()
    {
        require('template/batch/batch_mt.php');
    }

    function copy_mms()
    {
        require('template/batch/copy_mms.php');
    }

    function historique($type)
    {
        $batch_list = $this->getBatchList();

        $day_graph = 'invisible';
        $batch_week_graph = 'invisible';
        $batch_day_graph = 'invisible';
        $facture_graph = 'invisible';

        $day = "";
        $DayData = "[]";
        $BatchDayData = [];
        $batch_day = '';
        $datafacture1 = [];
        $datafacture2 = [];

        $totalfacture1 = 0;
        $totalfacture2 = 0;

        $day1 = date('Y-m-d', strtotime('monday this week'));;
        $day2 = date('Y-m-d');

        switch ($type) {
            case 'day':
                $day_graph = '';
                $day = $_REQUEST['day'];
                $DayData = $this->getDayData($day);
                break;
            case 'batch_day':
                $batch_day_graph = '';
                $batch_day = $_REQUEST['batch'];
                $days = explode('|',$_REQUEST['periode']);
                $day1 = $days[0];
                $day2 = $days[1];
                $BatchDayData = $this->getBatchDayData($day1,$day2,$batch_day);
                break;
            case 'batch_week':
                $batch_week_graph = '';
                break;
            case 'facture':
                $facture_graph = '';

                $week1 = $_POST['week1']; 
                list($year, $weekNumber) = explode('-W', $week1);
                $date = new DateTime();
                $date->setISODate($year, $weekNumber);

                // Premier jour (lundi)
                $day1week1 = $date->format('Y-m-d');

                // Dernier jour (dimanche)
                $date->modify('+6 days');
                $day2week1 = $date->format('Y-m-d');

                $data1 = $this->getFactureData($day1week1,$day2week1);

                $labels1 = $data1[0];
                $datafacture1 = $data1[1];

                if( isset($_POST['week2']) && !empty($_POST['week2']) )
                {
                    $week2 = $_POST['week2']; 
                    list($year, $weekNumber) = explode('-W', $week2);
                    $date = new DateTime();
                    $date->setISODate($year, $weekNumber);

                    // Premier jour (lundi)
                    $day1week2 = $date->format('Y-m-d');

                    // Dernier jour (dimanche)
                    $date->modify('+7 days');
                    $day2week2 = $date->format('Y-m-d');

                    $data2 = $this->getFactureData($day1week2,$day2week2);
                    $labels2 = $data2[0];
                    $datafacture2 = $data2[1];
                }
                break;
            default:
                # code...
                break;
        }

        require('template/batch/historique0.php');
    }

    function execute($serveur, $batch, $args)
    {
        $host = '10.250.90.162';
        $user = 'op_ascms';
        $pass = 'Op3n4dm1n';

        if ($serveur == '200') {
            $host = '10.250.90.200';
            $user = 'sdsa.user';
            $pass = 'Sds@eneo';
        }


        $config = [
            'host'    => $host,
            'port'    => 22,
            'user'    => $user,
            'pass'    => $pass,
            'script'  => $this->SCRIPTS[$batch],
            'args'  => $args,
            'timeout' => 300,
        ];

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        header('Connection: keep-alive');

        while (ob_get_level() > 0) ob_end_clean();
        set_time_limit(0);
        ignore_user_abort(false);

        $this->runRemote($config);
    }

    // ─── Helper $this->sse ───────────────────────────────────────────────────────────────
    function sse(string $text, string $type = 'log'): void
    {
        $payload = json_encode(['text' => $text, 'ts' => microtime(true)]);
        echo "event: {$type}\ndata: {$payload}\n\n";
        flush();
    }

    // ─── Exécution distante ───────────────────────────────────────────────────────
    function runRemote(array $cfg): void
    {
        // 1. Connexion
        $this->sse("Connexion à {$cfg['host']}:{$cfg['port']}...", 'info');

        $ssh = new SSH2($cfg['host'], $cfg['port'], $cfg['timeout']);

        // 2. Authentification par mot de pa$this->sse
        $this->sse("Authentification ({$cfg['user']})...", 'info');

        if (!$ssh->login($cfg['user'], $cfg['pass'])) {
            $this->sse("Authentification échouée pour '{$cfg['user']}'", 'error');
            $this->sse('', 'done');
            return;
        }

        $this->sse("Authentifié. Lancement du script...", 'info');

        // 3. Exécution avec callback temps réel
        $ssh->setTimeout($cfg['timeout']);

        $command  = "chmod +x " . escapeshellarg($cfg['script']);
        $command .= " && " . escapeshellarg($cfg['script']) . " " . $cfg['args'] . " 2>&1";

        if ($cfg['script'] == $this->SCRIPTS['run_check_batchs'] || $cfg['script'] == $this->SCRIPTS['mra_cms_scp3'])
            $command = escapeshellarg($cfg['script']) . " 2>&1";

        if (str_contains($cfg['script'], 'pkill'))
            $command = escapeshellarg($cfg['script']) . " " . $cfg['args'] . " 2>&1";
        $buffer = '';
        // var_dump($command);

        session_write_close();
        $ssh->exec($command, function (string $chunk) use (&$buffer): void {
            session_write_close();
            if (connection_aborted()) {
                return;
            }

            // Traitement ligne par ligne pour un rendu propre dans le navigateur
            $buffer .= $chunk;

            while (($pos = strpos($buffer, "\n")) !== false) {
                $line   = substr($buffer, 0, $pos);
                $buffer = substr($buffer, $pos + 1);

                $line = rtrim($line, "\r");
                if ($line !== '') {
                    $this->sse($line, 'log');
                }
            }
        });

        // Vider ce qui reste dans le buffer (dernière ligne sans \n)
        if (trim($buffer) !== '') {
            $this->sse(rtrim($buffer, "\r\n"), 'log');
        }

        $exitCode = $ssh->getExitStatus();

        $this->sse("Script terminé. Code de sortie : {$exitCode}", 'info');
        $this->sse('', 'done');
    }

    function check($batch)
    {
        $repo = new CmsRepository(new DbConnect());
        $result = $repo->checkbatch($this->CHECKS[$batch]);

        print $result['C'];
    }

    function checkfacture($datefacturation)
    {
        $date = str_replace("_", "-", $datefacturation);
        $request = "with tmp as (
                            select /*+ parallel(8) */ b.nom_area as REGION,count(be.num_rec) as NBRE_FACTURE
                            from business_struct b
                            join bill_extraction_list be on b.cod_unicom = be.cod_unicom
                            where be.f_batch_date = date'$date'
                            group by b.nom_area
                            )
                            select NVL(SUM(NBRE_FACTURE), 0) c from tmp";
        $repo = new CmsRepository(new DbConnect());
        $result = $repo->checkbatch($request);

        print $result['C'];
    }

    function kill($serveur, $batch)
    {
        $btch = 'pkill';
        $args = ' -f ' . $this->KILLS[$batch];

        $host = '10.250.90.162';
        $user = 'op_ascms';
        $pass = 'Op3n4dm1n';

        if ($serveur == '200') {
            $host = '10.250.90.162';
            $user = 'sdsa.user';
            $pass = 'Sds@eneo';
        }


        $config = [
            'host'    => $host,
            'port'    => 22,
            'user'    => $user,
            'pass'    => $pass,
            'script'  => $btch,
            'args'  => $args,
            'timeout' => 300,
        ];

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        header('Connection: keep-alive');

        while (ob_get_level() > 0) ob_end_clean();
        set_time_limit(0);
        ignore_user_abort(false);

        $this->runRemote($config);
    }

    public function get_bordereau($date)
    {
        $host = '10.250.90.200';
        $username = 'sdsa.user';
        $password = 'Sds@eneo';

        $remoteFile = "/u02/VAS_APPS/BORDEREAU-FACTURATION/BORDEREAU_DVC_$date.zip";

        $sftp = new SFTP($host);

        if (!$sftp->login($username, $password)) {
            http_response_code(500);
            exit('Connexion SFTP impossible');
        }

        // Vérifie que le fichier existe
        if (!$sftp->file_exists($remoteFile)) {
            http_response_code(404);
            exit('Fichier introuvable');
        }

        $fileSize = $sftp->filesize($remoteFile);

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="BORDEREAU_DVC_' . $date . '.zip"');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: no-cache');
        header('Pragma: public');

        $result = $sftp->get($remoteFile, function ($chunk) {
            echo $chunk;

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();
        });

        if ($result === false) {
            http_response_code(500);
            exit('Erreur lors du téléchargement du fichier.');
        }

        exit;
    }

    private function getDayData($day)
    {
        $repo = new CmsRepository(new DbConnect());

        $arg = $day;
        $statement =
            "
        SELECT 
            batch,
            TO_CHAR(startAt, 'YYYY-MM-DD HH24:MI:SS') AS STARTAT,
            TO_CHAR(endAt,   'YYYY-MM-DD HH24:MI:SS') AS ENDAT,
            beginWith,
            endWith,
            duration,
            status
        FROM CMS_RFC.batch_execution
        WHERE TRUNC(STARTAT) = TO_DATE(:day, 'YYYY-MM-DD')
        ORDER BY STARTAT
        ";
        $params = ["day" => $arg];
        $rows = $repo->getAllWithParams($statement, $params);
        $output = "[";
        foreach ($rows as $item) {
            $output = $output."{
            x: \"".$item["BATCH"]."\",
            y: [
                                new Date(\"".$item["STARTAT"]."\").getTime(),
                                new Date(\"".$item["ENDAT"]."\").getTime()
                            ]
            },";
        }
        $output = $output."]";

        
        // var_dump($output);
        return $output;
    }

    private function getBatchDayData($day1,$day2,$batch)
    {
        $repo = new CmsRepository(new DbConnect());

        $statement =
            "
            SELECT
                batch,
                TO_CHAR(startAt, 'YYYY-MM-DD HH24:MI:SS') AS STARTAT,
                TO_CHAR(endAt, 'YYYY-MM-DD HH24:MI:SS') AS ENDAT,
                beginWith - endWith AS process,
                duration,
                TO_CHAR(
                ROUND((beginWith - endWith) / NULLIF(duration, 0), 2),
                    'FM999999990.00',
                    'NLS_NUMERIC_CHARACTERS = ''.,'''
                ) AS speed,
                status
            FROM CMS_RFC.batch_execution
            WHERE TRUNC(STARTAT) >= TO_DATE(:day1, 'YYYY-MM-DD')
            AND TRUNC(STARTAT) <= TO_DATE(:day2, 'YYYY-MM-DD')
            AND batch = :batch 
            AND duration <> 0
            AND beginWith <> 0
            ORDER BY STARTAT
        ";
        $params = [
            "day1" => $day1,
            "day2" => $day2,
            "batch" => $batch,
        ];
        $rows = $repo->getAllWithParams($statement, $params);
        $output = [];
        $process = [];
        $duration = [];
        $data = [];
        $labels = [];
        foreach ($rows as $item) {
            $duration[]=$item['DURATION'];
            $process[]=$item['PROCESS'];
            $data[]=$item['SPEED'];
            $labels[]=$item['STARTAT'];
        }
        $output[] = $duration;
        $output[] = $data;
        $output[] = $process;
        $output[] = $labels;

        
        // var_dump(json_encode($output[1]));
        // var_dump(($output[1]));
        return $output;
    }

    private function getFactureData($day1,$day2)
    {
        $repo = new CmsRepository(new DbConnect());

        $statement =
        "WITH dates AS (
                SELECT TO_DATE(:day1, 'YYYY-MM-DD') + LEVEL - 1 AS dt
                FROM DUAL
                CONNECT BY LEVEL <= TO_DATE(:day2, 'YYYY-MM-DD') - TO_DATE(:day1, 'YYYY-MM-DD') + 1
            )
            SELECT /*+ parallel(8) */
                d.dt AS dates,
                COUNT(be.num_rec) AS NBRE_FACTURE
            FROM dates d
            LEFT JOIN bill_extraction_list be
            ON TRUNC(be.f_batch_date) = d.dt
            LEFT JOIN business_struct b
            ON b.cod_unicom = be.cod_unicom
            GROUP BY d.dt
            ORDER BY d.dt
        ";
        $params = [
            "day1" => $day1,
            "day2" => $day2,
        ];
        $rows = $repo->getAllWithParams($statement, $params);
        // var_dump($rows);
        $output = [];
        $dates = [];
        $nbre = [];
        foreach ($rows as $item) {
            $dates[]=$item['DATES'];
            $nbre[]=$item['NBRE_FACTURE'];
        }
        $output[] = $dates;
        $output[] = $nbre;

        // var_dump($output);
        return $output;
    }

    private function getBatchList()
    {
        $repo = new CmsRepository(new DbConnect());

        $statement =
            "
        SELECT 
            *
        FROM CMS_RFC.batch_list
        ";
        $rows = $repo->getAll($statement);
        return $rows;
    }
}
