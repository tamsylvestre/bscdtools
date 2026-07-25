<?php

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Settings;

    require_once('src/lib/database.php');

    class PowernetRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAllUsers():array
        {
            $statement ="SELECT Decode(c.zt,'0','enable','1','disabled','2','locked') account_status,c.* FROM prepaid.qx_czy  c";


            $conn = $this->dbconnect->getPowertnetDB();
            $stid = oci_parse($conn, $statement);
            oci_execute($stid);
            
            $users = [];

            while(($row = oci_fetch_array($stid, OCI_ASSOC| OCI_RETURN_NULLS)) !== false)
            {        
                $users[]= $row;
            }

            oci_free_statement($stid);
            oci_close($conn);

            return $users;

        }

        // public function getWithParams($statement,$params):array
        // {
        //     foreach ($params as $key => $value) {
        //         $statement->bindValue(':'.$key, $value);
        //     }

        //     $conn = $this->dbconnect->getPowertnetDB();
        //     $stid = oci_parse($conn, $statement);
        //     oci_execute($stid);
            
        //     $users = [];

        //     while(($row = oci_fetch_array($stid, OCI_ASSOC| OCI_RETURN_NULLS)) !== false)
        //     {        
        //         $users[]= $row;
        //     }

        //     oci_free_statement($stid);
        //     oci_close($conn);

        //     return $users;

        // }

        public function getWithParams($statement, $params): array
        {
            $conn = $this->dbconnect->getPowertnetDB();
            $stid = oci_parse($conn, $statement);

            // Correction du Binding pour Oracle
            foreach ($params as $key => $value) {
                // oci_bind_by_name utilise une référence (&$value)
                // On crée une variable intermédiaire pour éviter les problèmes de référence en boucle
                oci_bind_by_name($stid, ':' . $key, $params[$key]);
            }

            if (!oci_execute($stid)) {
                $e = oci_error($stid);
                throw new Exception($e['message']);
            }

            $results = [];
            // Récupération des données
            while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) !== false) {
                $results[] = $row;
            }

            oci_free_statement($stid);
            // Attention : ne fermez la connexion ici que si vous ne l'utilisez plus ailleurs
            // oci_close($conn); 

            return $results;
        }

        public function getSalesLogs_($startdate,$enddate,$partner)
        {
            // 1. Augmenter les limites
            set_time_limit(0);
            ini_set('memory_limit', '2G'); // Ajustez selon votre serveur

            $statement =
            "
                SELECT
                    /*+ parallel(4) */ 
                    ot.ordersid receipt,
                    ot.meterno,
                    ot.token,
                    p.posname,
                    ot.op_time,
                    om.tenderamt,
                    om.msgid,
                    om.energy,
                    om.posid,
                    om.OPERATOR,
                    om.repay_amount,
                    --x.costmilliseconds,
                    x.clientid--,
                    --x.respcode,
                    --x.createdate
                FROM prepaid.order_token ot
                    left JOIN prepaid.order_master om ON om.ordersid = ot.ordersid
                    left JOIN prepaid.pos_station p ON p.posid = om.posid
                    left JOIN prepaid.xmlvend_server_msg x ON x.msgid = om.msgid
                    WHERE 
                    ot.op_time BETWEEN To_Date('$startdate 00:00:00', 'YYYY-MM-DD hh24:mi:ss') AND To_Date('$enddate 23:59:59', 'YYYY-MM-DD hh24:mi:ss') AND posname  IN ( '$partner')
                    AND om.order_type IN ('01')
                    AND x.clientid is not null
                    ORDER BY ot.op_time desc
            ";


            $conn = $this->dbconnect->getPowertnetDB();
            $stid = oci_parse($conn, $statement);
            oci_execute($stid);
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // 1. Récupération des noms de colonnes pour l'en-tête
            $ncols = oci_num_fields($stid);
            for ($i = 1; $i <= $ncols; $i++) {
                $columnName = oci_field_name($stid, $i);
                // Utilisation de la nouvelle syntaxe [colonne, ligne]
                $sheet->setCellValue([$i, 1], $columnName);
            }

            // 3. Écriture des données ligne par ligne
            $rowNumber = 2;
            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $colNumber = 1;
                foreach ($row as $value) {
                    // $sheet->setCellValueByColumnAndRow($colNumber, $rowNumber, $value);
                    // On convertit l'index de colonne (ex: 1) en lettre (ex: A)
                    $sheet->setCellValue([$colNumber, $rowNumber], $value);
                    $colNumber++;
                }
                $rowNumber++;
                
                // Libération périodique de la mémoire si nécessaire (Garbage Collector)
                if ($rowNumber % 10000 == 0) {
                    gc_collect_cycles();
                }
            }

            // 4. Sauvegarde
            $writer = new Xlsx($spreadsheet);
            $fileName = "./template/exports/powernet/saleslogs/Vente_" . $partner.'_'.$startdate.'_'.$enddate . ".xlsx";
            $writer->save($fileName);

            oci_free_statement($stid);
            oci_close($conn);

            // return $users;
        }

        public function getSalesLog_s($startdate,$enddate,$partner){

            // 1. Augmenter les limites
            set_time_limit(0);
            ini_set('memory_limit', '2G'); // Ajustez selon votre serveur

            // Préparer la requête SQL avec des optimisations
            $statement = "
                SELECT
                    /*+ parallel(4) */ 
                    ot.ordersid AS receipt,
                    ot.meterno,
                    ot.token,
                    p.posname,
                    ot.op_time,
                    om.tenderamt,
                    om.msgid,
                    om.energy,
                    om.posid,
                    om.OPERATOR,
                    om.repay_amount,
                    x.clientid
                FROM prepaid.order_token ot
                LEFT JOIN prepaid.order_master om ON om.ordersid = ot.ordersid
                LEFT JOIN prepaid.pos_station p ON p.posid = om.posid
                LEFT JOIN prepaid.xmlvend_server_msg x ON x.msgid = om.msgid
                WHERE 
                    ot.op_time BETWEEN TO_DATE('$startdate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') 
                    AND TO_DATE('$enddate 23:59:59', 'YYYY-MM-DD HH24:MI:SS') 
                    AND p.posname IN ('$partner')
                    AND om.order_type = '01'
                    AND x.clientid IS NOT NULL
                ORDER BY ot.op_time DESC
            ";

            var_dump($statement);

            $conn = $this->dbconnect->getPowertnetDB();
            $stid = oci_parse($conn, $statement);
            oci_execute($stid);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

                // 2. Récupérer les noms de colonnes pour l'en-tête
                $ncols = oci_num_fields($stid);
                for ($i = 1; $i <= $ncols; $i++) {
                    $columnName = oci_field_name($stid, $i);
                    // Utiliser la nouvelle syntaxe [colonne, ligne]
                    $sheet->setCellValue([$i, 1], $columnName);
                }

                // 3. Écrire les données ligne par ligne
                $rowNumber = 2;
                while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    $colNumber = 1;
                    foreach ($row as $value) {
                        $sheet->setCellValue([$colNumber, $rowNumber], $value);
                        $colNumber++;
                    }
                    $rowNumber++;

                    // Libérer périodiquement de la mémoire si nécessaire (Garbage Collector)
                    if ($rowNumber % 5000 == 0) {
                        gc_collect_cycles();
                    }
                }

                // 4. Sauvegarde dans un fichier
                $writer = new Xlsx($spreadsheet);
                $fileName = "./template/exports/powernet/saleslogs/Vente_" . $partner . '_' . $startdate . '_' . $enddate . ".xlsx";
                $writer->save($fileName);

                // Libérer la déclaration et la connexion
                oci_free_statement($stid);
                oci_close($conn);

        }

        public function getSalesLogs3($startdate,$enddate,$partner){
            // 1. Augmenter les limites
            set_time_limit(0);
            ini_set('memory_limit', '2G'); // Ajustez selon votre serveur

            // Préparer la requête SQL avec des optimisations
            $statement = "
                SELECT
                    /*+ parallel(4) */ 
                    ot.ordersid AS receipt,
                    ot.meterno,
                    ot.token,
                    p.posname,
                    ot.op_time,
                    om.tenderamt,
                    om.msgid,
                    om.energy,
                    om.posid,
                    om.OPERATOR,
                    om.repay_amount,
                    x.clientid
                FROM prepaid.order_token ot
                LEFT JOIN prepaid.order_master om ON om.ordersid = ot.ordersid
                LEFT JOIN prepaid.pos_station p ON p.posid = om.posid
                LEFT JOIN prepaid.xmlvend_server_msg x ON x.msgid = om.msgid
                WHERE 
                    ot.op_time BETWEEN TO_DATE('$startdate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') 
                    AND TO_DATE('$enddate 23:59:59', 'YYYY-MM-DD HH24:MI:SS') 
                    AND p.posname IN ('$partner')
                    AND om.order_type = '01'
                    AND x.clientid IS NOT NULL
                ORDER BY ot.op_time DESC
            ";

            $conn = $this->dbconnect->getPowertnetDB();
            $stid = oci_parse($conn, $statement);
            oci_execute($stid);

            // Ouvrir un fichier CSV pour écriture
            $fileName = "./template/exports/powernet/saleslogs/Vente_" . $partner . '_' . $startdate . '_' . $enddate . ".csv";
            $fp = fopen($fileName, 'w');

            if ($fp === false) {
                die("Erreur lors de l'ouverture du fichier.");
            }

            // 2. Récupérer les noms de colonnes pour l'en-tête
            $ncols = oci_num_fields($stid);
            $header = [];
            for ($i = 1; $i <= $ncols; $i++) {
                $header[] = oci_field_name($stid, $i);
            }

            // Écrire l'en-tête dans le fichier CSV
            fputcsv($fp, $header);

            // 3. Écrire les données ligne par ligne par lots
            $rowCount = 0;
            $batchSize = 1000; // Taille du lot

            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                fputcsv($fp, $row); // Écrire chaque ligne dans le fichier CSV
                $rowCount++;

                // Libération périodique de la mémoire si nécessaire
                if ($rowCount % $batchSize == 0) {
                    gc_collect_cycles(); // Libérer la mémoire après chaque lot
                }
            }

            // Libération finale de la mémoire après le traitement complet
            gc_collect_cycles();

            // Fermer le fichier
            fclose($fp);

            // Libérer la déclaration et la connexion
            oci_free_statement($stid);
            oci_close($conn);

            echo $rowCount;
        }
        
        public function getSalesLogs($startdate,$enddate,$partner){
            // 1. Augmenter les limites
            set_time_limit(0);
            ini_set('memory_limit', '1G'); // Ajustez selon votre serveur

            // Préparer la requête SQL avec des optimisations
            $statement = "
                SELECT
                    /*+ parallel(4) */ 
                    ot.ordersid AS receipt,
                    ot.meterno,
                    ot.token,
                    p.posname,
                    ot.op_time,
                    om.tenderamt,
                    om.msgid,
                    om.energy,
                    om.posid,
                    om.OPERATOR,
                    om.repay_amount,
                    x.clientid
                FROM prepaid.order_token ot
                LEFT JOIN prepaid.order_master om ON om.ordersid = ot.ordersid
                LEFT JOIN prepaid.pos_station p ON p.posid = om.posid
                LEFT JOIN prepaid.xmlvend_server_msg x ON x.msgid = om.msgid
                WHERE 
                    ot.op_time BETWEEN TO_DATE('$startdate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') 
                    AND TO_DATE('$enddate 23:59:59', 'YYYY-MM-DD HH24:MI:SS') 
                    AND p.posname IN ('$partner')
                    AND om.order_type = '01'
                    AND x.clientid IS NOT NULL
                ORDER BY ot.op_time DESC
            ";

            $conn = $this->dbconnect->getPowertnetDB();
            $stid = oci_parse($conn, $statement);
            oci_execute($stid);

            // Initialisation des variables
            $rowCount = 0;
            $batchSize = 200000; // Nombre de lignes par fichier
            $fileIndex = 1; // Index pour le nom du fichier
            $fileName = "./template/exports/powernet/saleslogs/Vente_" . $partner . '_' . $startdate . '_' . $enddate . "_part$fileIndex.csv";
            $fp = fopen($fileName, 'w');

            if ($fp === false) {
                die("Erreur lors de l'ouverture du fichier.");
            }

            // Récupérer les noms de colonnes pour l'en-tête
            $ncols = oci_num_fields($stid);
            $header = [];
            for ($i = 1; $i <= $ncols; $i++) {
                $header[] = oci_field_name($stid, $i);
            }

            // Écrire l'en-tête dans le premier fichier CSV
            fputcsv($fp, $header);

            // Écrire les données ligne par ligne
            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                fputcsv($fp, $row); // Écrire chaque ligne dans le fichier CSV
                $rowCount++;

                // Libération de mémoire si nécessaire
                if ($rowCount % 5000 == 0) {
                    gc_collect_cycles(); // Libérer la mémoire
                }

                // Vérifier si la limite du fichier est atteinte
                if ($rowCount >= $batchSize) {
                    fclose($fp); // Fermer le fichier actuel
                    $fileIndex++; // Incrémenter l'index du fichier
                    $fileName = "./template/exports/powernet/saleslogs/Vente_" . $partner . '_' . $startdate . '_' . $enddate . "_part$fileIndex.csv";
                    $fp = fopen($fileName, 'w'); // Ouvrir un nouveau fichier
                    if ($fp === false) {
                        die("Erreur lors de l'ouverture du fichier.");
                    }
                    // Réécrire l'en-tête dans le nouveau fichier
                    fputcsv($fp, $header);
                    $rowCount = 0; // Réinitialiser le compteur de lignes
                }
            }

            // Libération finale de la mémoire après le traitement complet
            gc_collect_cycles();

            // Fermer le dernier fichier
            fclose($fp);

            // Libérer la déclaration et la connexion
            oci_free_statement($stid);
            oci_close($conn);

            return $rowCount;
        }
    }