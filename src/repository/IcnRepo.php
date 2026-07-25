<?php

    require_once('src/lib/database.php');

    class IcnRepository
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

        public function getOne($request):array
        {
            $statement = $this->dbconnect->getICNDb()->prepare($request);
                
            $statement->execute();
            
            $users = [];

            if($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $users = $row;
            }

            return $users;

        }

        public function unapplied($debut,$fin)
        {
            $pdo = $this->dbconnect->getICNDb(); 
            $connOracle = $this->dbconnect->getCMSDb(); 
            $pdo->exec("CREATE TEMPORARY TABLE temp_aci_exclude (numero_aci VARCHAR(100) PRIMARY KEY)");
                
            $stmtInsert = $pdo->prepare("INSERT IGNORE INTO temp_aci_exclude (numero_aci) VALUES (?)");

            $queryOracle = 
            "
                SELECT
                        c.*,
                        CASE WHEN e.type_operation IS NULL THEN 'AUTRES' END AS type_operation,
                        e.nom_client
                    from
                    (
                    select /*+ parallel(8) */ distinct

                                (case
                                            when regexp_like(c.datos_pago,'ACI No:[a-zA-Z0-9\.]+')
                                                        then regexp_replace(regexp_substr(c.datos_pago, '@ACI No:[a-zA-Z0-9\.]+@'),'(\.0+)|E[0-9]|[^0-9]')
                                            else
                                                        regexp_replace(regexp_substr(c.comentarios_cli,'BP[0-9\.]+@'), 'BP|(\.0+)|@')
                                end) numero_aci,

                                to_char(g.f_actual, 'dd/mm/yyyy') date_traitement,
                                num_recibos nombre_factures_traitees,
                                imp_gest_cobro montant_aci
                    from cmsadmin.gestiones_cobro g
                    join cmsadmin.cobtemp c on c.num_gest_cobro = g.num_gest_cobro and g.cod_caja = c.cod_caja
                    WHERE g.cod_caja = 5701473 AND g.f_actual >= TO_DATE('$debut', 'YYYY-MM-DD') --AND g.f_actual <= TO_DATE('fin', 'YYYY-MM-DD')
                    ) c
                    LEFT JOIN kpirhextract.elements_aci e ON e.numero_aci = c.numero_aci
                    order by c.date_traitement
            ";
            // 4. Exécution de la requête Oracle
            $stidOracle = oci_parse($connOracle, $queryOracle);
            oci_execute($stidOracle);

            // 5. Insertion des données Oracle vers la table temporaire MySQL par lots
            $stmtInsert = $pdo->prepare("INSERT IGNORE INTO temp_aci_exclude (numero_aci) VALUES (?)");
            
            $pdo->beginTransaction();
            $count = 0;
            while ($rowOracle = oci_fetch_array($stidOracle, OCI_ASSOC)) {
                if (!empty($rowOracle['NUMERO_ACI'])) {
                    $stmtInsert->execute([$rowOracle['NUMERO_ACI']]);
                    $count++;
                }
                // Commit tous les 5000 pour ne pas saturer le log de transaction
                if ($count % 5000 === 0) {
                    $pdo->commit();
                    $pdo->beginTransaction();
                }
            }
            $pdo->commit(); // Finaliser les dernières lignes

            // 6. Requête MySQL finale avec Jointure d'exclusion (Anti-Join)
            $queryMysql = "
                SELECT t.reference, t.name, t.region, t.unit, t.status, 
                    t.reasonForRefusal, t.bank, t.branch, t.town, 
                    t.amount, t.paymentDate, t.paymentMode, 
                    t.createdAt, t.updatedAt
                FROM v_transactions t
                LEFT JOIN temp_aci_exclude tmp ON t.reference = tmp.numero_aci
                WHERE t.createdAt BETWEEN :debut AND :fin
                AND tmp.numero_aci IS NULL
                ORDER BY t.updatedAt DESC";

            $stmtMysql = $pdo->prepare($queryMysql);
            $stmtMysql->execute([
                'debut' => "$debut 00:00:00",
                'fin'   => "$fin 23:59:59"
            ]);

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
            $writer->save('./template/exports/aci/unapplied/UNAPPLIED_ACI_'.$debut.'_AU_'.$fin.'.xlsx');

        }

    }