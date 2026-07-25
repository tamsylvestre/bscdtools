<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

require_once('src/lib/database.php');


class CmsRepository
{
    private $dbconnect;

    public function __construct($dbconnect)
    {
        $this->dbconnect = $dbconnect;
    }

    public function getAllUsers($statement): array
    {

        $conn = $this->dbconnect->getCMSDb();
        $stid = oci_parse($conn, $statement);
        oci_execute($stid);

        $users = [];

        while (($row = oci_fetch_array($stid, OCI_ASSOC | OCI_RETURN_NULLS)) !== false) {
            $users[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $users;
    }

    public function checkbatch($statement): array
    {

        $conn = $this->dbconnect->getCMSDb();
        $stid = oci_parse($conn, $statement);
        oci_execute($stid);

        $output = [];

        if (($row = oci_fetch_array($stid, OCI_ASSOC | OCI_RETURN_NULLS)) !== false) {
            $output = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $output;
    }

    public function getASC($statement): array
    {
        $stid = oci_parse($this->dbconnect->getCMSDb(), $statement);
        oci_execute($stid);

        $asc = [];

        while (($row = oci_fetch_array($stid, OCI_ASSOC | OCI_RETURN_NULLS)) !== false) {
            $asc[] = $row;
        }

        return $asc;
    }

    public function getAnnulations($statement)
    {
        $conn = $this->dbconnect->getCMSDb();
        $stid = oci_parse($conn, $statement);
        oci_execute($stid);

        $maxRowsPerFile = 200000;
        $fileCount = 1;
        $rowCount = 0;
        $handle = null;

        $folder = "./template/exports/annulations/*";

        // Récupère tous les fichiers correspondant au pattern
        $files = glob($folder);

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Supprime le fichier
            }
        }

        while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) !== false) {

            // Si on atteint la limite ou si c'est le premier passage, on change de fichier
            if ($rowCount % $maxRowsPerFile === 0) {
                if ($handle) {
                    fclose($handle);
                }
                $fileName = "./template/exports/annulations/export_partie_" . $fileCount . ".csv";
                $handle = fopen($fileName, 'w');

                // Optionnel : Ajouter les entêtes de colonnes
                fputcsv($handle, array_keys($row), ';');

                $fileCount++;
            }

            // Écriture de la ligne dans le CSV
            fputcsv($handle, $row, ';');
            $rowCount++;
        }

        // Nettoyage
        if ($handle) {
            fclose($handle);
        }
        oci_free_statement($stid);
        oci_close($conn);

        return "Extraction terminé : $rowCount lignes réparties dans " . ($fileCount - 1) . " fichiers.";
    }

    public function getAll($statement)
    {
        $conn = $this->dbconnect->getCMSDb();
        $stid = oci_parse($conn, $statement);
        oci_execute($stid);

        $users = [];

        while (($row = oci_fetch_array($stid, OCI_ASSOC | OCI_RETURN_NULLS)) !== false) {
            $users[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $users;
    }

    public function getAllWithParams($statement, $params): array
    {

        $stmt = oci_parse($this->dbconnect->getCMSDb(), $statement);

        if (!$stmt) {
            $e = oci_error($this->dbconnect->getCMSDb());
            throw new Exception($e['message']);
        }

        foreach ($params as $key => $value) {
            oci_bind_by_name($stmt, ":$key", $params[$key]);
        }

        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            throw new Exception($e['message']);
        }

        $rows = [];

        while ($row = oci_fetch_assoc($stmt)) {
            $rows[] = $row;
        }

        oci_free_statement($stmt);

        return $rows;
    }
    
}
