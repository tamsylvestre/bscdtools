<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Spécifiez le chemin de votre fichier Excel
$filePath = __DIR__ . '/aci.xlsx'; // Remplacez par le chemin de votre fichier Excel

// Charger le fichier Excel
$spreadsheet = IOFactory::load($filePath);

// Sélectionner la première feuille
$sheet = $spreadsheet->getActiveSheet();

// Récupérer les données
$data = $sheet->toArray();

// Afficher les données dans un tableau HTML
if (!empty($data)) {
    // echo '<table border="1">';
    
    // Afficher l'en-tête
    // echo '<tr>';
    // foreach ($data[0] as $header) {        
    //     echo '<th>' . htmlspecialchars($header) . '</th>';
    // }
    // echo '</tr>';
    
    // Afficher les lignes de données
    for ($i = 0; $i < count($data); $i++) {
        echo '<tr>';
        foreach ($data[$i] as $cell) {
            // echo '<td>' . htmlspecialchars($cell) . '</td>';
            $txt = explode(" ",$cell);
            // echo '<td>' . htmlspecialchars($txt[sizeof($txt)-2]) . '</td>';
            print($txt[sizeof($txt)-2]);
            echo '<br>';
        }
        echo '</tr>';
    }
    
    // echo '</table>';
} else {
    echo 'Aucune donnée à afficher.';
}
?>