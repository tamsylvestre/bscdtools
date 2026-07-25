<?php

    require_once('src/lib/database.php');
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class AciRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll($request):array
        {
            $statement = $this->dbconnect->getICNDb()->prepare($request);
                
            $statement->execute();
            
            $users = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $users[]= $row;
            }

            return $users;

        }

        public function creatednotaccounted($reffile,$debut)
        {
            $pdo = $this->dbconnect->getICNDb();             
            $pdo->exec(
                "CREATE TEMPORARY TABLE temp_aci_exclude_report (
            numero_aci VARCHAR(100) PRIMARY KEY,
            `GL Account` VARCHAR(100), 
            `Company Code` VARCHAR(100), 
            `Assignment Reference` VARCHAR(100),
            `Journal Entry` VARCHAR(100),
            `Journal Entry Type` VARCHAR(100),
            `Posting Date` VARCHAR(100),
            `Posting Key` VARCHAR(100),
            `Amount in Company` VARCHAR(100),
            `Code Currency` VARCHAR(100),
            `Tax Code` VARCHAR(100),
            `Clearing Journal Entry` VARCHAR(100),
            `Profit Center` VARCHAR(100),
            `Segment` VARCHAR(100),
            `Journal Entry Item Text` VARCHAR(100),
            `Number of Items` VARCHAR(100)
            )");                
            $stmtInsert = $pdo->prepare("INSERT IGNORE INTO temp_aci_exclude_report (numero_aci) VALUES (?)");


            if (!is_file($reffile)) { die("Erreur Fichier introuvable"); }

            $spreadsheet = IOFactory::load($reffile);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true); // valeurs formatées, clés A,B,C...

            $count = sizeof($rows);
            // var_dump($count);
            // print '<br>';

            $pdo->beginTransaction();
            // $count = 0;
            for($i=2; $i<=$count; $i++)
            {
                $val = $sheet->getCell('M'.$i)->getValue();
                $txt = explode(" ",$val);
                $NUMERO_ACI = $txt[sizeof($txt)-2];
                
                // print $NUMERO_ACI;
                // print '<br>';
                if($i==100)
                    break;
                $stmtInsert->execute([$NUMERO_ACI]);
                
                // Commit tous les 5000 pour ne pas saturer le log de transaction
                if ($i % 5000 === 0) {
                    $pdo->commit();
                    $pdo->beginTransaction();
                }
            }            
            $pdo->commit();

            // $queryMysql = "select * from temp_aci_exclude";
            // $stmtMysql = $pdo->prepare($queryMysql);
            // $stmtMysql->execute();

            // 6. Requête MySQL finale avec Jointure d'exclusion (Anti-Join)
            $queryMysql = "
                SELECT t.reference, t.name, t.region, t.unit, t.status, 
                    t.reasonForRefusal, t.bank, t.branch, t.town, 
                    t.amount, t.paymentDate, t.paymentMode, 
                    t.createdAt, t.updatedAt
                FROM v_transactions t
                LEFT JOIN temp_aci_exclude_report tmp ON t.reference = tmp.numero_aci
                WHERE t.createdAt >= :debut
                AND tmp.numero_aci IS NULL
                ORDER BY t.updatedAt DESC";

            $stmtMysql = $pdo->prepare($queryMysql);
            $stmtMysql->execute([
                'debut' => "$debut 00:00:00"
            ]);

            // $acis = [];
            // while ($row = $stmtMysql->fetch(PDO::FETCH_ASSOC)) {
            //     $acis[]=$row;
            // }

            // return $acis;

            // 7. Génération Excel (PhpSpreadsheet)
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // En-têtes
            $columns = [
                'Reference', 'Nom', 'Region', 'Unité', 'Statut', 'Refus', 
                'Banque', 'Agence', 'Ville', 'Montant', 'Date Paiement', 
                'Mode', 'Créé le', 'Mis à jour le'
            ];
            $sheet->fromArray($columns, NULL, 'A1');

            // Données
            $rowNumber = 2;
            while ($row = $stmtMysql->fetch(PDO::FETCH_NUM)) {
                $sheet->setCellValue([1, $rowNumber], $row[0]); // Reference
                // ... remplir les autres colonnes ...
                // Astuce : utilisez setCellValue([$col, $row], $val) comme vu précédemment
                
                foreach ($row as $index => $value) {
                    $sheet->setCellValue([$index + 1, $rowNumber], $value);
                }

                if ($rowNumber % 5000 === 0) gc_collect_cycles();
                $rowNumber++;
            }

            // Exportation
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('./template/exports/aci/creatednotaccounted/CREATED_in_ICN_since_'.$debut.'_NOT_SAP_ACCOUNTED.xlsx');

        }

        public function accountednotcreated($reffile,$debut)
        {
            $pdo = $this->dbconnect->getICNDb();             
            $pdo->exec(
                "CREATE TEMPORARY TABLE temp_aci_exclude_report (
            numero_aci VARCHAR(100) PRIMARY KEY,
            `GL Account` VARCHAR(100), 
            `Company Code` VARCHAR(100), 
            `Assignment Reference` VARCHAR(100),
            `Journal Entry` VARCHAR(100),
            `Journal Entry Type` VARCHAR(100),
            `Posting Date` VARCHAR(100),
            `Posting Key` VARCHAR(100),
            `Amount in Company` VARCHAR(100),
            `Code Currency` VARCHAR(100),
            `Tax Code` VARCHAR(100),
            `Clearing Journal Entry` VARCHAR(100),
            `Profit Center` VARCHAR(100),
            `Segment` VARCHAR(100),
            `Journal Entry Item Text` VARCHAR(100),
            `Number of Items` VARCHAR(100)
            )");                
            $stmtInsert = $pdo->prepare("INSERT IGNORE INTO temp_aci_exclude_report (numero_aci) VALUES (?)");


            if (!is_file($reffile)) { die("Erreur Fichier introuvable"); }

            $spreadsheet = IOFactory::load($reffile);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true); // valeurs formatées, clés A,B,C...

            $count = sizeof($rows);
            // var_dump($count);
            // print '<br>';

            $pdo->beginTransaction();
            // $count = 0;
            for($i=2; $i<=$count; $i++)
            {
                $val = $sheet->getCell('M'.$i)->getValue();
                $txt = explode(" ",$val);
                $NUMERO_ACI = $txt[sizeof($txt)-2];
                
                // print $NUMERO_ACI;
                // print '<br>';
                if($i==100)
                    break;
                $stmtInsert->execute([$NUMERO_ACI]);
                
                // Commit tous les 5000 pour ne pas saturer le log de transaction
                if ($i % 5000 === 0) {
                    $pdo->commit();
                    $pdo->beginTransaction();
                }
            }            
            $pdo->commit();

            // $queryMysql = "select * from temp_aci_exclude";
            // $stmtMysql = $pdo->prepare($queryMysql);
            // $stmtMysql->execute();

            // 6. Requête MySQL finale avec Jointure d'exclusion (Anti-Join)
            $queryMysql = "
                SELECT t.reference, t.name, t.region, t.unit, t.status, 
                    t.reasonForRefusal, t.bank, t.branch, t.town, 
                    t.amount, t.paymentDate, t.paymentMode, 
                    t.createdAt, t.updatedAt
                FROM v_transactions t
                LEFT JOIN temp_aci_exclude_report tmp ON t.reference = tmp.numero_aci
                WHERE t.createdAt >= :debut
                AND tmp.numero_aci IS NULL
                ORDER BY t.updatedAt DESC";

            $stmtMysql = $pdo->prepare($queryMysql);
            $stmtMysql->execute([
                'debut' => "$debut 00:00:00"
            ]);

            // $acis = [];
            // while ($row = $stmtMysql->fetch(PDO::FETCH_ASSOC)) {
            //     $acis[]=$row;
            // }

            // return $acis;

            // 7. Génération Excel (PhpSpreadsheet)
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // En-têtes
            $columns = [
                'Reference', 'Nom', 'Region', 'Unité', 'Statut', 'Refus', 
                'Banque', 'Agence', 'Ville', 'Montant', 'Date Paiement', 
                'Mode', 'Créé le', 'Mis à jour le'
            ];
            $sheet->fromArray($columns, NULL, 'A1');

            // Données
            $rowNumber = 2;
            while ($row = $stmtMysql->fetch(PDO::FETCH_NUM)) {
                $sheet->setCellValue([1, $rowNumber], $row[0]); // Reference
                // ... remplir les autres colonnes ...
                // Astuce : utilisez setCellValue([$col, $row], $val) comme vu précédemment
                
                foreach ($row as $index => $value) {
                    $sheet->setCellValue([$index + 1, $rowNumber], $value);
                }

                if ($rowNumber % 5000 === 0) gc_collect_cycles();
                $rowNumber++;
            }

            // Exportation
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('./template/exports/aci/creatednotaccounted/CREATED_in_ICN_since_'.$debut.'_NOT_SAP_ACCOUNTED.xlsx');

        }

    }