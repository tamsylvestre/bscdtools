<?php

$os = PHP_OS_FAMILY;

if ($os === 'Windows') {

    // ==========================================
    // DEVELOPPEMENT WINDOWS 11
    // ==========================================

    $sharedDirectory = '\\\\10.250.90.33\\shared folders\\CMS_reports\\COLLECTIONS\\SHARED\\UNPAID\\CURRENT_YEAR\\DCUD';
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

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Fichiers partagés</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .download {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>

</head>

<body>

    <h2>Fichiers disponibles</h2>

    <p>
        <strong>Système :</strong>
        <?= htmlspecialchars($os) ?>
    </p>

    <p>
        <strong>Répertoire :</strong>

        <code>
            <?= htmlspecialchars($sharedDirectory) ?>
        </code>
    </p>


    <table>

        <thead>

            <tr>

                <th>Nom</th>
                <th>Taille</th>
                <th>Date</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($files as $file): ?>

                <?php

                // Ignorer . et ..
                if ($file === '.' || $file === '..') {
                    continue;
                }


                // Chemin complet compatible Windows/Linux
                $filePath = $sharedDirectory .
                    DIRECTORY_SEPARATOR .
                    $file;


                // Afficher uniquement les fichiers
                if (!is_file($filePath)) {
                    continue;
                }

                ?>

                <tr>

                    <td>

                        <?= htmlspecialchars($file) ?>

                    </td>


                    <td>

                        <?php

                        $size = filesize($filePath);

                        if ($size !== false) {

                            echo round($size / 1024 / 1024, 2) . ' MB';
                        } else {

                            echo '-';
                        }

                        ?>

                    </td>


                    <td>

                        <?= date(
                            'd/m/Y H:i:s',
                            filemtime($filePath)
                        ) ?>

                    </td>


                    <td>

                        <a
                            class="download"
                            href="download.php?file=<?= urlencode($file) ?>">
                            Télécharger
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</body>

</html>
