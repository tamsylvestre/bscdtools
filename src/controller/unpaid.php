<?php


class C_Unpaid
{
    private $reposytories = [
        'DCUD' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DCUD",
        'DCUY' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DCUY",
        'DRC' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRC",
        'DRE' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRE",
        'DRNEA' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRNEA",
        'DRONO' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRONO",
        'DRSANO' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRSANO",
        'DRSM' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRSM",
        'DRSOM' => "\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DRSOM",
    ];

    public function __construct()
    {
        CheckUserConnect();
    }

    function files($DIVISION)
    {
        $os = PHP_OS_FAMILY;

        if ($os === 'Windows') {

            // ==========================================
            // DEVELOPPEMENT WINDOWS 11
            // ==========================================

            $sharedDirectory = $this->reposytories[$DIVISION]; //'\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DCUD';
        } else {

            // ==========================================
            // PRODUCTION LINUX
            // ==========================================

            /*
            * Le partage Windows est monté par exemple sur :
            *
            * /mnt/shared_files
            *
            * On accède ensuite au sous-répertoire :
            *
            * /mnt/shared_files/UNPAID/CURRENT_YEAR/DRONO
            */

            $sharedDirectory =
                '/mnt/shared_files/UNPAID/CURRENT_YEAR/DRONO';
        }


        // ==========================================
        // VERIFICATION DU REPERTOIRE
        // ==========================================

        if (!is_dir($sharedDirectory)) {

            die('<h3>Erreur</h3>' .
                '<p>Le répertoire partagé est inaccessible :</p>' .
                '<code>' .
                htmlspecialchars($sharedDirectory) .
                '</code>');
        }


        // ==========================================
        // RECUPERATION DES FICHIERS
        // ==========================================

        $files = scandir($sharedDirectory);

        if ($files === false) {

            die('Impossible de lire le contenu du répertoire.');
        }

        require("template/unpaid.php");
    }

    function download($DIVISION,$fileR)
    {
        $os = PHP_OS_FAMILY;

        if ($os === 'Windows') {
            $directory = $this->reposytories[$DIVISION];
        }
        else{
            $directory = '/mnt/windows_share';
        }

        // if (!isset($_GET['file'])) {
        //     die('Fichier non spécifié.');
        // }

        // Récupération du nom du fichier
        // $file = basename($_GET['file']);
        $file = str_replace('__','.',$fileR);

        // Chemin complet
        $filePath = $directory . DIRECTORY_SEPARATOR . $file;

        // Vérification
        if (!file_exists($filePath) || !is_file($filePath)) {
            die('Fichier introuvable.');
        }

        // Téléchargement
        header('Content-Type: application/octet-stream');

        header(
            'Content-Disposition: attachment; filename="' .
            basename($file) .
            '"'
        );

        header('Content-Length: ' . filesize($filePath));

        header('Cache-Control: no-cache');

        readfile($filePath);

        exit;
    }
}
