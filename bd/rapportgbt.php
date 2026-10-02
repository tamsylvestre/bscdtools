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
$migration  = 1;


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
        i.num_itin num_itineraire,
        c.nom_unicom agence,
        i.num_ciclo num_cycle,
        c.num_mrsp code_mrc,
        i.ruta,
        i.est_ciclo_itin statut_itineraire,
        i.f_lreal date_lecture,
        i.f_gen date_generation,
        i.f_ftrat date_traitement,
        i.nl_anom pl_en_anomalie,
        i.nl_gen pl_generes,
        i.nl_ok pl_lus,
        c.desc_itin,
        i.f_actual

        from cmsreport.tb_customers_infos c
        left join ciclos_itin i on i.num_itin= c.num_itin
        where i.num_ciclo={$cycle}  and i.nl_gen!=0 and i.num_mrsp=2011 and i.est_ciclo_itin in('IR006')
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
   select distinct
            s.nom_area REGION
            ,s.cod_unicom cod_agence
            ,s.nom_unicom AGENCE
            ,s.nis_rad service_num,
            i.lect_real index_lu,
            i.num_apa,
            s.cust_name,
            af.num_sum service_point,
            af.num_af,
            af.f_gen,
            bt.co_an code_ano,
            (select co.desc_cod from codigos co where bt.co_an=co.cod ) libelle_ano,
            bt.num_os,
            bt.tip_os
            ,(select t.DESC_TIPO from tipos t where bt.tip_os = t.tipo) libelle_os
            ,(select es.desc_est from estados es where af.est_af = es.estado) statut_anomalie
            ,(select es.desc_est from estados es where  s.est_serv=es.estado) statut_contrat
            ,(select t.DESC_TIPO from tipos t where  af.tip_fact=t.tipo) billing_type
            ,af.usuario,
            af.f_actual,
            af.f_fact,
            af.f_gen,
            af.f_uce

FROM cmsadmin.trabpend_af AF
join cmsreport.tb_customers_infos s on af.num_sum = s.num_sum
join cmsadmin.itiner i on af.num_sum = i.num_sum and i.num_ciclo=9 and i.num_mrsp in (2011) /*and i.lect_real = -1*/
left join cmsadmin.an_trabpend_af bt on af.num_af = bt.num_af

WHERE af.f_gen BETWEEN /*sysdate-3/24*/ date'2026-09-31' AND date'2026-10-04'-1/86400
AND (select es.desc_est from estados es where af.est_af= es.estado) LIKE 'NOT BILLED%'
AND (select es.desc_est from estados es where  af.num_sum=s.num_sum and s.est_serv=es.estado) NOT LIKE 'INACT%'
AND S.cod_tar  NOT LIKE '3%'
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
$filename = 'Rapport Anomalies GBT 08-2026_01.xlsx';

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
