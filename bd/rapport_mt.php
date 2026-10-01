<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;


/*
|--------------------------------------------------------------------------
| PARAMETRES
|--------------------------------------------------------------------------
*/

$cycle = 1;
$mrsp  = 2010;


/*
|--------------------------------------------------------------------------
| REPOSITORY ORACLE
|--------------------------------------------------------------------------
*/
$repo = new CmsRepository(new DbConnect());


/*
|--------------------------------------------------------------------------
| REQUETE 1 : RAPPORT MIGRATION
|--------------------------------------------------------------------------
*/
$statementMigration = 
"
    SELECT DISTINCT
        adt.NUM_CICLO AS cycle,
        s.nom_area AS region,
        s.nom_zona AS division,
        s.nom_unicom AS agence,
        s.cod_unicom,
        adt.num_mrsp,
        su.usr_number2 AS ref_geo,
        adt.F_LREAL AS date_releve,
        adt.F_LECT_ANT,
        adt.NUM_SUM,
        s.nis_rad AS service_no,
        estado(su.est_serv) AS status_contrat,
        s.cust_name,
        adt.num_APA AS compteur,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO003'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS ACTIVE_OFF_PEAK_IMP,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO002'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS ACTIVE_PEAK_IMP,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO008'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS ACTIVE_OFF_PEAK_EXP,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO007'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS ACTIVE_PEAK_EXP,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO005'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS REACTIVE_OFF_PEAK_IMP,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO025'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS REACTIVE_PEAK_IMP,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO016'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS POWER_MIN,

        MAX(
            CASE
                WHEN adt.TIP_CSMO = 'CO026'
                THEN adt.lect_real
                ELSE 0
            END
        ) OVER(PARTITION BY adt.num_sum) AS POWER_MAX

    FROM ITINER adt

    JOIN cmsreport.tb_customers_infos s
        ON adt.num_sum = s.num_sum

    JOIN CMSADMIN.SUMCON su
        ON su.nis_rad = s.nis_rad

    JOIN ciclos_itin c
        ON c.num_itin = adt.num_itin
    AND c.num_ciclo = adt.num_ciclo

    WHERE adt.NUM_MRSP = {$mrsp}
    AND adt.num_ciclo = {$cycle}
    AND s.cod_tar LIKE '3%'
    AND c.est_ciclo_itin = 'IR003'
";


/*
|--------------------------------------------------------------------------
| EXECUTION REQUETE 1
|--------------------------------------------------------------------------
*/
$rowsMigration = $repo->getAll($statementMigration);


/*
|--------------------------------------------------------------------------
| REQUETE 2 : COMPTEUR EN ANOMALIE
|--------------------------------------------------------------------------
*/
$statementCompteur = 
"
    WITH data AS (

        SELECT DISTINCT
            i.num_apa

        FROM itiner i

        WHERE i.num_ciclo = {$cycle}
        AND i.num_mrsp = {$mrsp}

        AND EXISTS (
            SELECT 1
            FROM trabpend_af t

            WHERE t.num_sum = i.num_sum
                AND t.f_actual > SYSDATE - 1
                AND t.programa LIKE 'LECC0510_c'
        )
    )

    SELECT
        d.num_apa,
        'Compteur en anomalie' AS observation

    FROM data d

    UNION ALL

    SELECT
        a.num_apa,
        'Compteur non généré' AS observation

    FROM CMS_RFC.anomalie_mt_copie a

    WHERE NOT EXISTS (

        SELECT 1
        FROM itiner i

        WHERE i.num_apa = a.num_apa
        AND i.num_ciclo = {$cycle}
        AND i.co_al = 'AN313'
        AND i.num_mrsp = {$mrsp}
    )
";


/*
|--------------------------------------------------------------------------
| EXECUTION REQUETE 2
|--------------------------------------------------------------------------
*/
$rowsCompteur = $repo->getAll($statementCompteur);


/*
|--------------------------------------------------------------------------
| REQUETE 3 : ANOMALIE MT
|--------------------------------------------------------------------------
*/
$statementAnomalie = 
"
    SELECT
        BS.NOM_AREA,
        BS.NOM_ZONA,
        BS.COD_UNICOM,
        BS.NOM_UNICOM,
        S.nis_rad,
        C.NOM_CLI || ' ' || C.APE1_CLI || ' ' || C.APE2_CLI AS nom_client,
        S.num_sum,
        estado(S.EST_SERV) AS statut_client,

        codigo(AN.CO_AN) AS type_ano,
        codigo(TA.CO_NIV_ANOM) AS niveau_ano,
        TA.F_FACT AS mois,
        estado(TA.EST_AF) AS statut_ano,
        AN.num_os AS OS_Numero,
        tipo(AN.tip_os) AS OS_Typologie

    FROM TRABPEND_af TA

    JOIN an_trabpend_af AN
        ON TA.NUM_AF = AN.NUM_AF

    JOIN sumcon S
        ON S.NUM_SUM = TA.NUM_SUM

    JOIN business_struct BS
        ON S.COD_UNICOM = BS.COD_UNICOM

    JOIN clientes C
        ON C.COD_CLI = S.COD_CLI

    WHERE S.COD_TAR LIKE '3%'
    AND TA.EST_AF LIKE 'SA3%'
    AND S.EST_SERV NOT IN ('EC020', 'EC021')
";


/*
|--------------------------------------------------------------------------
| EXECUTION REQUETE 3
|--------------------------------------------------------------------------
*/
$rowsAnomalie = $repo->getAll($statementAnomalie);


/*
|--------------------------------------------------------------------------
| FONCTION POUR REMPLIR UNE FEUILLE
|--------------------------------------------------------------------------
*/
function fillExcelSheet(
    $spreadsheet,
    $sheetIndex,
    $sheetName,
    $rows
) {

    $sheet = $spreadsheet->getSheet($sheetIndex);

    $sheet->setTitle($sheetName);

    /*
    |--------------------------------------------------------------------------
    | Aucun résultat
    |--------------------------------------------------------------------------
    */
    if (empty($rows)) {

        $sheet->setCellValue(
            'A1',
            'Aucun résultat'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Entêtes
    |--------------------------------------------------------------------------
    */
    $headers = array_keys($rows[0]);

    foreach ($headers as $index => $header) {

        $column = Coordinate::stringFromColumnIndex(
            $index + 1
        );

        $sheet->setCellValue(
            $column . '1',
            strtoupper($header)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Données
    |--------------------------------------------------------------------------
    */
    $rowNumber = 2;

    foreach ($rows as $row) {

        $columnNumber = 1;

        foreach ($headers as $header) {

            $column = Coordinate::stringFromColumnIndex(
                $columnNumber
            );

            $value = $row[$header];

            $sheet->setCellValue(
                $column . $rowNumber,
                $value
            );

            $columnNumber++;
        }

        $rowNumber++;
    }


    /*
    |--------------------------------------------------------------------------
    | Style entêtes
    |--------------------------------------------------------------------------
    */
    $lastColumn = Coordinate::stringFromColumnIndex(
        count($headers)
    );

    $sheet
        ->getStyle("A1:{$lastColumn}1")
        ->getFont()
        ->setBold(true);


    /*
    |--------------------------------------------------------------------------
    | Figer la première ligne
    |--------------------------------------------------------------------------
    */
    $sheet->freezePane('A2');


    /*
    |--------------------------------------------------------------------------
    | Filtre
    |--------------------------------------------------------------------------
    */
    $sheet->setAutoFilter(
        "A1:{$lastColumn}" . ($rowNumber - 1)
    );


    /*
    |--------------------------------------------------------------------------
    | Largeur automatique
    |--------------------------------------------------------------------------
    */
    foreach ($headers as $index => $header) {

        $column = Coordinate::stringFromColumnIndex(
            $index + 1
        );

        $sheet
            ->getColumnDimension($column)
            ->setAutoSize(true);
    }
}


/*
|--------------------------------------------------------------------------
| CREATION DU FICHIER EXCEL
|--------------------------------------------------------------------------
*/
$spreadsheet = new Spreadsheet();


/*
|--------------------------------------------------------------------------
| ONGLET 1
|--------------------------------------------------------------------------
*/
fillExcelSheet(
    $spreadsheet,
    0,
    'Rapport Migration',
    $rowsMigration
);


/*
|--------------------------------------------------------------------------
| ONGLET 2
|--------------------------------------------------------------------------
*/
$spreadsheet->createSheet();

fillExcelSheet(
    $spreadsheet,
    1,
    'Compteur Anomalie',
    $rowsCompteur
);


/*
|--------------------------------------------------------------------------
| ONGLET 3
|--------------------------------------------------------------------------
*/
$spreadsheet->createSheet();

fillExcelSheet(
    $spreadsheet,
    2,
    'Anomalie MT',
    $rowsAnomalie
);


/*
|--------------------------------------------------------------------------
| DOSSIER DE SORTIE
|--------------------------------------------------------------------------
*/
$outputDir = __DIR__;

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0775, true);
}


/*
|--------------------------------------------------------------------------
| NOM DU FICHIER
|--------------------------------------------------------------------------
*/
$filename = 'Rapport Migration MT 08-2026_01.xlsx';

$filepath = $outputDir . DIRECTORY_SEPARATOR . $filename;


/*
|--------------------------------------------------------------------------
| GENERATION
|--------------------------------------------------------------------------
*/
$writer = new Xlsx($spreadsheet);

$writer->save($filepath);


/*
|--------------------------------------------------------------------------
| RETOUR
|--------------------------------------------------------------------------
*/
echo json_encode([
    'success' => true,
    'file' => $filepath,
    'cycle' => $cycle,
    'mrsp' => $mrsp,
    'migration' => count($rowsMigration),
    'compteur_anomalie' => count($rowsCompteur),
    'anomalie_mt' => count($rowsAnomalie)
]);
