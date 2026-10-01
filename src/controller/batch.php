<?php

use phpseclib3\Net\SSH2;
use phpseclib3\Net\SFTP;
use phpseclib3\Crypt\PublicKeyLoader;

require_once('src/repository/CmsRepo.php');
require_once('src/repository/MraRepo.php');

class C_Batch
{
    // Scripts autorisés (whitelist de sécurité)
    private  $SCRIPTS = [
        'run_check_batchs'  => 'run-check-batchs.sh',
        'Cfechab'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/check-fechab.sh',
        'Sfechab'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/set-fechab.sh',
        'mra_cms_scp3'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/check/mra_cms_scp3.sh',
        'cms_mra_scp'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/cms_mra_scp.sh',
        'lecc300'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-lecc0300-heat.sh',
        'lecc510' => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0510-log.sh',
        'lecc600'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0600-log.sh',
        'lecc540'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0540-log.sh',
        'calcsmo'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-calc_csmo-log.sh',
        'estimation'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-estimation-log.sh',
        'facc000'  => "/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-facc0001-log.sh",
        'os_anomalia'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-os_anomalias.sh',
        'campania'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-campania.sh',
        'reading_report'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-only-reading-report.sh',
        'cb_split'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb_split-log.sh',
        'cb_conv'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb_conv-log.sh',
        'cb_conv_old'  => '/opt/openlink/gencode_batch/bin/run-cb_conv-log.sh',
        'cb_stprod'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb-stprod-log.sh',
        'cb_stext'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-cb-stext-log.sh',
        'depose_bt'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-upload-bills.sh',
        'depose_mt'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-upload-mv-bills.sh',
        'gen_bordereau'  => '/u02/VAS_APPS/BORDEREAU-FACTURATION/Extract-Bordereau-Facturation-NOC.sh',
        'check_bordereau'  => '/u02/VAS_APPS/BORDEREAU-FACTURATION/check-bordereau.sh',
        'lecc300_lecc540'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0300-540-log.sh',
        'facc_cb_prod'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-facturation-facc-to-cb_stprod-log.sh',
        'cfechab_amr'  => '/opt/openlink/gencode_batch/bin_amr/check-fechab.sh',
        'sfechab_amr'  => '/opt/openlink/gencode_batch/bin_amr/set-fechab.sh',
        'lecc0100'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0100-heat.sh',
        'lecc0200'  => '/home/op_ascms/cmsprod/tbatch/cms_mra/prod/run-lecc0200-heat.sh',
        'config_ini'  => '/opt/app/war/configs/check-config_ini.sh',
        'sconfig_ini' => "/opt/app/war/configs/set-config.sh",
        'scycle' => "/opt/app/war/configs/set-cycle.sh",
        'smigration' => "/opt/app/war/configs/set-migration.sh",
        'show_anomalie_copie' => "/home/op_ascms/cmsprod/tbatch/cms_mra/prod/show_anomalie_copie.sh",
        'scycle162' => "/home/op_ascms/cmsprod/tbatch/cms_mra/prod/set-cycle.sh",
        'ccycle162' => "/home/op_ascms/cmsprod/tbatch/cms_mra/prod/check-cycle.sh"
    ];

    private  $KILLS = [
        'mra_cms_scp3'  => 'mra_cms_scp3.sh',
        'cms_mra_scp' => 'cms_mra_scp.sh',
        'lecc300'  => 'LECC0300',
        'lecc510' => 'LECC0510',
        'lecc600'  => 'LECC0600',
        'lecc540'  => 'LECC0540',
        'calcsmo'  => 'calc_csmo',
        'estimation'  => 'estimation',
        'facc000'  => "FACC0001",
        'os_anomalia'  => 'os_anomalias',
        'campania'  => 'campania',
        'reading_report'  => 'reading_report_gen',
        'cb_split'  => 'cb_split',
        'cb_conv'  => 'cb_conv',
        'cb_conv_old'  => 'cb_conv',
        'cb_stprod'  => 'cb_stProd',
        'cb_stext'  => 'cb_stExt',
        'lecc0100' => 'LECC0100',
        'lecc0200' => 'LECC0200'
    ];

    private  $CHECKS = [
        'lecc300' => "select nvl(sum(nl_gen),0) c from ciclos_itin where est_ciclo_itin='IR004'",
        'lecc510' => "select count(*) c from  ciclos_itin  where est_ciclo_itin='IR009'",
        'lecc600'  => "select  count(*) c  from itiner_aus  where EST_LECT = 'EL003'",
        'lecc540'  => "select  count(*) c from ciclos_itin  where est_ciclo_itin='IR005' and f_lteor <= sysdate",
        'calcsmo'  => "select  count(*) c from itifact where ind_tratado=2 and ind_embalsado=2 and f_actual>sysdate-30",
        'calcsmo_mt'  => "select count(*)/8 c from itifact where ind_tratado=2 and ind_embalsado=2 and num_sum in (select num_sum from sumcon where cod_tar  like '3%') and f_actual>sysdate-30",
        'estimation'  => "select  count(*) c from sum_estimar where ind_tratado=2 and ind_embalsado=2 and f_actual>sysdate-30",
        'facc000'  => "select  count(*) c from serv_facturar where ind_fact=2 and ind_embalsado=2 and f_actual>sysdate-30",
        'cb_split'  => "SELECT est_act,
                            COUNT(*) AS c
                        FROM recibos_dispatch
                        WHERE est_act = 'ER010'
                        AND f_actual >= SYSDATE - 30
                        GROUP BY est_act",
        'cb_conv'  => "SELECT est_act,
                            COUNT(*) AS c
                        FROM recibos_dispatch
                        WHERE est_act = 'ER015'
                        AND f_actual >= SYSDATE - 30
                        GROUP BY est_act",
        'cb_conv_old'  => "SELECT est_act,
                            COUNT(*) AS c
                        FROM recibos_dispatch
                        WHERE est_act = 'ER015'
                        AND f_actual >= SYSDATE - 30
                        GROUP BY est_act",
        'cb_stprod'  => "SELECT 'PS001' AS est_imagen,
                            COUNT(*) AS c
                        FROM imagenes_dispatch
                        WHERE est_imagen = 'PS001'
                        AND f_actual >= SYSDATE - 30",
        'cb_stext'  => "SELECT 'PS002' AS est_imagen,
                            COUNT(*) AS c
                        FROM imagenes_dispatch
                        WHERE est_imagen = 'PS002'
                        AND f_actual >= SYSDATE - 30",
        'lecc0100'  => "SELECT
                            count(*) c
                            FROM ciclos_itin
                            WHERE num_ciclo=extract(month from sysdate)
                            AND est_ciclo_itin ='IR001'
                            AND num_mrsp not in (2010,2011)
                            AND F_LTEOR <= (case
                                when TO_CHAR(sysdate, 'DAY') in ('MONDAY   ','TUESDAY  ','WEDNESDAY','SATURDAY ','SUNDAY   ') then sysdate+2
                                when TO_CHAR(sysdate, 'DAY') in ('THURSDAY ','FRIDAY   ') then sysdate+4
                            end)",
        'lecc0200'  => "SELECT
                        count(*) c
                        FROM ciclos_itin
                        where num_ciclo=extract(month from sysdate)
                        and est_ciclo_itin ='IR002'",
        'ir0002'     => "SELECT
                        count(*) c
                        FROM
                        ciclos_itin
                        WHERE est_ciclo_itin='IR002' 
                        AND num_ciclo =  EXTRACT(MONTH FROM SYSDATE)",
        'ir003'     => "SELECT
                        count(*) c
                        FROM
                        ciclos_itin
                        WHERE est_ciclo_itin='IR003' 
                        AND num_ciclo =  EXTRACT(MONTH FROM SYSDATE)"
    ];

    private $FILES = [
        'config_ini' => "/opt/app/war/configs/config.ini",
        'fechab' => "/opt/openlink/gencode_batch/bin_amr/CLEAR_FECHAB",
        'cycle' => "/opt/app/war/configs/cycle.ini",
        'migration' => "/opt/app/war/configs/migration.ini",
        'cycle162' => "/home/op_ascms/cmsprod/tbatch/cms_mra/prod/cycle.ini",
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

        $facture_periode1 = "";
        $facture_periode2 = "";
        $facture_periode1_nbr = 0;
        $facture_periode2_nbr = 0;

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
                $days = explode('|', $_REQUEST['periode']);
                $day1 = $days[0];
                $day2 = $days[1];
                $BatchDayData = $this->getBatchDayData($day1, $day2, $batch_day);
                break;
            case 'batch_week':
                $batch_week_graph = '';
                break;
            case 'facture':
                $facture_graph = '';

                // $week1 = $_POST['week1']; 
                // list($year, $weekNumber) = explode('-W', $week1);
                // $date = new DateTime();
                // $date->setISODate($year, $weekNumber);

                // // Premier jour (lundi)
                // $day1week1 = $date->format('Y-m-d');

                // // Dernier jour (dimanche)
                // $date->modify('+6 days');
                // $day2week1 = $date->format('Y-m-d');

                $days = explode('|', $_REQUEST['periode1']);
                $facture_periode1 = $days[0] . ' à ' . $days[1];

                $data1 = $this->getFactureData($days[0], $days[1]);

                $labels1 = $data1[0];
                $datafacture1 = $data1[1];

                $facture_periode1_nbr = array_sum($datafacture1);

                if (isset($_POST['periode2']) && !empty($_POST['periode2'])) {
                    // $week2 = $_POST['week2']; 
                    // list($year, $weekNumber) = explode('-W', $week2);
                    // $date = new DateTime();
                    // $date->setISODate($year, $weekNumber);

                    // // Premier jour (lundi)
                    // $day1week2 = $date->format('Y-m-d');

                    // // Dernier jour (dimanche)
                    // $date->modify('+7 days');
                    // $day2week2 = $date->format('Y-m-d');

                    $days = explode('|', $_REQUEST['periode2']);
                    $facture_periode2 = $days[0] . ' à ' . $days[1];

                    $data2 = $this->getFactureData($days[0], $days[1]);
                    $labels2 = $data2[0];
                    $datafacture2 = $data2[1];

                    $facture_periode2_nbr = array_sum($datafacture2);
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
        if ($batch == 'sconfig_ini') {
            $args = $_SESSION['args_config_ini'];
        }
        elseif ($batch == 'show_anomalie_copie') {
            $args =  $this->read_server_file_php(162, 'cycle162');
        }

        $host = '10.250.90.162';
        $user = 'op_ascms';
        $pass = 'Op3n4dm1n';

        if ($serveur == '200') {
            $host = '10.250.90.200';
            $user = 'sdsa.user';
            $pass = 'Sds@eneo';
        }

        if ($serveur == '33') {
            $host = '10.241.110.33';
            $user = 'sys_emoney';
            $pass = 'src/lib/id_rsa';
        }


        $config = [
            'host'    => $host,
            'port'    => 22,
            'user'    => $user,
            'pass'    => $pass,
            'script'  => $this->SCRIPTS[$batch],
            'args'  => $args,
            'timeout' => 0,
        ];

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        header('Connection: keep-alive');

        while (ob_get_level() > 0) ob_end_clean();
        set_time_limit(0);
        ignore_user_abort(false);

        try {

            if ($serveur == '33') {
                $this->runRemoteRSA($config);
            } else {
                $this->runRemote($config);
            }
        } catch (\Throwable $e) {

            $this->sse(
                "ERREUR PHP : " . $e->getMessage(),
                'error'
            );

            $this->sse('', 'done');
        }
    }

    function getRSAKey($keyPath)
    {
        try {
            // Charger la clé privée
            $key = PublicKeyLoader::load(
                file_get_contents($keyPath)
            );

            return $key;
        } catch (\Throwable $e) {
            return '';
        }
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

    function runRemoteRSA(array $cfg): void
    {
        // 1. Connexion
        $this->sse(
            "Connexion à {$cfg['host']}:{$cfg['port']}...",
            'info'
        );

        $ssh = new SSH2(
            $cfg['host'],
            $cfg['port'],
            $cfg['timeout']
        );

        // 2. Chargement de la clé RSA
        $this->sse(
            "Chargement de la clé RSA...",
            'info'
        );

        try {
            $key = PublicKeyLoader::load(
                file_get_contents($cfg['pass'])
            );
        } catch (\Throwable $e) {
            $this->sse(
                "Impossible de charger la clé RSA : " . $e->getMessage(),
                'error'
            );
            $this->sse('', 'done');
            return;
        }

        // 3. Authentification SSH avec la clé RSA
        $this->sse(
            "Authentification RSA ({$cfg['user']})...",
            'info'
        );

        if (!$ssh->login($cfg['user'], $key)) {
            $this->sse(
                "Authentification RSA échouée pour '{$cfg['user']}'",
                'error'
            );
            $this->sse('', 'done');
            return;
        }

        $this->sse(
            "Authentifié avec la clé RSA. Lancement du script...",
            'info'
        );

        // 4. Timeout SSH
        $ssh->setTimeout($cfg['timeout']);

        // 5. Construction de la commande
        $command  = "chmod +x " . escapeshellarg($cfg['script']);
        $command .= " && "
            . escapeshellarg($cfg['script'])
            . " "
            . $cfg['args']
            . " 2>&1";

        if (
            $cfg['script'] == $this->SCRIPTS['run_check_batchs']
            || $cfg['script'] == $this->SCRIPTS['mra_cms_scp3']
        ) {
            $command = escapeshellarg($cfg['script']) . " 2>&1";
        }

        if (str_contains($cfg['script'], 'pkill')) {
            $command =
                escapeshellarg($cfg['script'])
                . " "
                . $cfg['args']
                . " 2>&1";
        }

        $buffer = '';

        session_write_close();

        // 6. Exécution avec retour temps réel
        $ssh->exec(
            $command,
            function (string $chunk) use (&$buffer): void {

                session_write_close();

                if (connection_aborted()) {
                    return;
                }

                $buffer .= $chunk;

                while (($pos = strpos($buffer, "\n")) !== false) {

                    $line = substr($buffer, 0, $pos);

                    $buffer = substr(
                        $buffer,
                        $pos + 1
                    );

                    $line = rtrim($line, "\r");

                    if ($line !== '') {
                        $this->sse($line, 'log');
                    }
                }
            }
        );

        // 7. Dernière ligne éventuelle
        if (trim($buffer) !== '') {
            $this->sse(
                rtrim($buffer, "\r\n"),
                'log'
            );
        }

        // 8. Code retour
        $exitCode = $ssh->getExitStatus();

        $this->sse(
            "Script terminé. Code de sortie : {$exitCode}",
            'info'
        );

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

    function checkitin($date)
    {
        $date = str_replace("_", "-", $date);
        $request = "SELECT COUNT(*) as c
                    FROM jobs
                    where source='EXPORT-DATA'
                    and (status = 'Transport' or status = 'Completed_w_errors')
                    and date(created_at) = '$date'";
        $repo = new MraRepository(new DbConnect());
        $result = $repo->getOne($request);

        print $result['c'];
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
            $output = $output . "{
            x: \"" . $item["BATCH"] . "\",
            y: [
                                new Date(\"" . $item["STARTAT"] . "\").getTime(),
                                new Date(\"" . $item["ENDAT"] . "\").getTime()
                            ]
            },";
        }
        $output = $output . "]";


        // var_dump($output);
        return $output;
    }

    private function getBatchDayData($day1, $day2, $batch)
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
            $duration[] = $item['DURATION'];
            $process[] = $item['PROCESS'];
            $data[] = $item['SPEED'];
            $labels[] = $item['STARTAT'];
        }
        $output[] = $duration;
        $output[] = $data;
        $output[] = $process;
        $output[] = $labels;


        // var_dump(json_encode($output[1]));
        // var_dump(($output[1]));
        return $output;
    }

    private function getFactureData($day1, $day2)
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
            $dates[] = $item['DATES'];
            $nbre[] = $item['NBRE_FACTURE'];
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

    function read_server_file($server, $file)
    {
        if ($server == '33') {
            $text = "";

            $sftp = new SFTP('10.241.110.33', 22, 60);

            // Chemin vers la clé privée RSA
            $keyPath = 'src/lib/id_rsa';

            try {
                // Charger la clé privée
                $key = PublicKeyLoader::load(
                    file_get_contents($keyPath)
                );

                // Connexion SFTP avec la clé RSA
                if (!$sftp->login('sys_emoney', $key)) {
                    exit('Connexion SFTP échouée');
                }

                // Récupération du fichier
                $text = $sftp->get($this->FILES[$file]);

                if ($text === false) {
                    exit('Impossible de récupérer le fichier : ' . $file);
                }

                print $text;
                return $text;
            } catch (\Throwable $e) {
                exit('Erreur SFTP : ' . $e->getMessage());
            }
        }
        elseif ($server == '162') {

            $sftp = new SFTP('10.250.90.162', 22, 60);

            if (!$sftp->login('op_ascms', 'Op3n4dm1n')) {
                exit('Connexion échouée');
            }

            // Récupération du contenu
            $text = $sftp->get($this->FILES[$file]);
            print $text;
            return $text;
        }
    }

    function read_server_file_php($server, $file)
    {
        if ($server == '33') {
            $text = "";

            $sftp = new SFTP('10.241.110.33', 22, 60);

            // Chemin vers la clé privée RSA
            $keyPath = 'src/lib/id_rsa';

            try {
                // Charger la clé privée
                $key = PublicKeyLoader::load(
                    file_get_contents($keyPath)
                );

                // Connexion SFTP avec la clé RSA
                if (!$sftp->login('sys_emoney', $key)) {
                    exit('Connexion SFTP échouée');
                }

                // Récupération du fichier
                $text = $sftp->get($this->FILES[$file]);

                if ($text === false) {
                    exit('Impossible de récupérer le fichier : ' . $file);
                }

                return $text;
            } catch (\Throwable $e) {
                exit('Erreur SFTP : ' . $e->getMessage());
            }
        }
        elseif ($server == '162') {

            $sftp = new SFTP('10.250.90.162', 22, 60);

            if (!$sftp->login('op_ascms', 'Op3n4dm1n')) {
                exit('Connexion échouée');
            }

            // Récupération du contenu
            $text = $sftp->get($this->FILES[$file]);

            return $text;
        }
    }

    function change_config_ini()
    {
        $data = json_decode(file_get_contents('php://input'), true);


        $fromDate  = $data['fromDate'] ?? null;
        $toDate    = $data['toDate'] ?? null;
        $lastTryMv = $data['lastTryMv'] ?? null;
        $lastTryLv = $data['lastTryLv'] ?? null;
        $server = $data['server'] ?? null;

        $args = $fromDate . ' ' . $toDate . ' ' . $lastTryMv . ' ' . $lastTryLv;

        $_SESSION['args_config_ini'] = $args;
    }

    function check_copy($batch)
    {
        $cycle = $this->read_server_file(33, 'cycle');
        $STATEMENTS = [
            'mt_ir003' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle and est_ciclo_itin='IR003' and num_mrsp=2010",
            'mt_ir033' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle and est_ciclo_itin='IR033' and num_mrsp=2010",
            'mt_pending' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle and (est_ciclo_itin='IR033' OR est_ciclo_itin='IR003') and num_mrsp=2010",
            'gbt_ir003' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle and est_ciclo_itin='IR003' and num_mrsp=2011",
            'gbt_ir033' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle and est_ciclo_itin='IR033' and num_mrsp=2011",
            'gbt_pending' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle and (est_ciclo_itin='IR033' OR est_ciclo_itin='IR003') and num_mrsp=2011",
            'mt_es003' => "SELECT count(*) c from zfa_f_request where req_status = 'ES003'",
            'gbt_es003' => "SELECT count(*) c from zfa_f_request where req_status = 'ES003'",
            'mt_ir009' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle  and est_ciclo_itin='IR009' and num_mrsp in (2010)",
            'gbt_ir009' => "SELECT count(*) c from ciclos_itin where num_ciclo=$cycle  and est_ciclo_itin='IR009' and num_mrsp in (2011)",
            'mt_itiner' => "SELECT count(*)/8 c from itiner where  num_mrsp = 2010 and num_ciclo=8  and lect_real !=-1",
            'gbt_itiner' => "SELECT count(*) c from itiner where  num_mrsp = 2011 and num_ciclo=8  and lect_real !=-1"
        ];

        $repo = new CmsRepository(new DbConnect());
        $result = $repo->getOne($STATEMENTS[$batch]);

        print $result['C'];
    }

    function upload_anomalie_mt_csv()
    {
        header('Content-Type: application/json; charset=utf-8');

        $data = json_decode(file_get_contents('php://input'), true);

        $values = $data['values'] ?? [];

        if (empty($values)) {

            echo json_encode([
                'success' => false,
                'message' => 'Aucune donnée reçue'
            ]);

            return;
        }

        $repo = new CmsRepository(new DbConnect());
        $repo->truncate('CMS_RFC.anomalie_mt_copie');

        $count = 0;

        foreach ($values as $value) {

            $value = trim($value);

            if ($value === '') {
                continue;
            }

            // INSERT Oracle ici
            $sql = "
                    INSERT INTO CMS_RFC.anomalie_mt_copie
                        (num_apa)
                    VALUES
                        (:num_apa)
                ";

            $params = [
                'num_apa'  => $value
            ];
           

            if ($count === 0) {                
                $count++;
            }else{
                if ($repo->insert($sql, $params))
                    $count++;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => ($count-1) . ' lignes importees.'
        ]);

        return;
    }

    function upload_anomalie_mt()
    {
        header('Content-Type: application/json; charset=utf-8');

        $data = json_decode(file_get_contents('php://input'), true);

        $values = $data['values'] ?? [];

        if (empty($values)) {

            echo json_encode([
                'success' => false,
                'message' => 'Aucune donnée reçue'
            ]);

            return;
        }

        $repo = new CmsRepository(new DbConnect());

        $count = 0;

        foreach ($values as $value) {

            $value = trim($value);

            if ($value === '') {
                continue;
            }

            // INSERT Oracle ici
            $sql = "
                    INSERT INTO CMS_RFC.anomalie_mt_copie
                        (num_apa)
                    VALUES
                        (:num_apa)
                ";

            $params = [
                'num_apa'  => $value
            ];

            if ($repo->insert($sql, $params))
                $count++;
        }

        echo json_encode([
            'success' => true,
            'message' => $count . ' lignes importees.'
        ]);

        return;
    }
    
    public function downloadAnomalieMtCopie()
    {
        try {

            $repo = new CmsRepository(new DbConnect());
            $statement = "select * from anomalie_mt_copie order by upload_date desc";
            $data = $repo->getAll($statement);

            // Racine du projet
            $directory = dirname(__DIR__, 2) . '/template/exports/batch_mt';

            if (!is_dir($directory)) {
                mkdir($directory, 0775, true);
            }

            // Fichier unique
            $filepath = $directory . '/anomalie_mt_copie.csv';

            // w = écrase le fichier existant
            $file = fopen($filepath, 'w');

            if (!$file) {
                throw new Exception(
                    "Impossible de créer le fichier : " . $filepath
                );
            }

            // BOM UTF-8 pour Excel
            fwrite($file, "\xEF\xBB\xBF");

            // Entêtes
            fputcsv($file, [
                'NUM_APA',
                'UPLOAD_DATE'
            ], ';');

            // Données
            foreach ($data as $row) {

                fputcsv($file, [
                    $row['NUM_APA'],
                    $row['UPLOAD_DATE']
                ], ';');
            }

            fclose($file);

            // Vérification
            if (!file_exists($filepath)) {
                throw new Exception("Le fichier CSV n'a pas été créé.");
            }

            // Envoyer le fichier au navigateur
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="AnomalieMT.csv"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');

            readfile($filepath);

            exit;
        } catch (Exception $e) {
            http_response_code(500);

            echo "Erreur : " . $e->getMessage();
            exit;
        }
    }

    function check_batch_mt($batch)
    {
        $cycle = $this->read_server_file_php(162, 'cycle162');
        $STATEMENTS = [
            'block_ano_mt' => "SELECT count(DISTINCT num_apa) c FROM itiner 
                                WHERE NUM_APA IN (SELECT num_apa FROM CMS_RFC.anomalie_mt_copie) 
                                AND num_ciclo=$cycle  AND co_al='AN313' AND num_mrsp=2010",
            'ano_mt' => "SELECT count(DISTINCT num_apa) c FROM itiner WHERE num_mrsp=2010 AND num_ciclo=$cycle  
                            AND  num_apa IN (SELECT num_apa FROM CMS_RFC.anomalie_mt_copie)"
        ];

        $repo = new CmsRepository(new DbConnect());
        $result = $repo->getOne($STATEMENTS[$batch]);

        print $result['C'];

        // var_dump($STATEMENTS);
    }

    function block_anomalie_mt(){
        $cycle = $this->read_server_file_php(162, 'cycle162');
        $params =[
            "cycle" => $cycle
        ];
        $statement = "UPDATE ITINER SET CO_al = 'AN313' WHERE  num_ciclo=:cycle  AND num_mrsp=2010 AND num_apa IN (SELECT num_apa FROM CMS_RFC.anomalie_mt_copie)";


        $repo = new CmsRepository(new DbConnect());
        $result = $repo->updateBTCH($statement,$params);

        print $result;
    }

}
