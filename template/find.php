<?php 

    use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

// Filtre pour ne lire que la colonne A
class ColumnAFilter implements IReadFilter {
    public function readCell($columnAddress, $row, $worksheetName = '') {
        return $columnAddress == 'A';
    }
}

function searchInExcelFiles($searchValue, $folderPath) {
    $files = glob($folderPath . "/*.xlsx");
    $filter = new ColumnAFilter();
    $foundIn = [];

    foreach ($files as $file) {
        $reader = IOFactory::createReaderForFile($file);
        $reader->setReadFilter($filter);
        $reader->setReadDataOnly(true); // Très important pour la vitesse
        
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        
        // On récupère les valeurs de la colonne A sous forme de tableau
        $columnValues = $sheet->toArray(null, true, true, true);
        
        foreach ($columnValues as $rowNumber => $rowData) {
            if ($rowData['A'] == $searchValue) {
                $foundIn[] = [
                    'file' => basename($file),
                    'row' => $rowNumber
                ];
            }
        }
        
        // Libérer la mémoire immédiatement
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        gc_collect_cycles();
    }
    return $foundIn;
}