<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ICN CASHING USER LIST</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb -float-sm-right">
                        <li class="breadcrumb-item"><a href="#"></a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">

            <div class='card col-12'>
                <div class='card-body'>

                    <table id="example1" class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Taille</th>
                                <th>Dernière Modification</th>
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

                                        <a class="btn btn-sm btn-info btn-flat btn-download"
                                            f="<?= BASE_URL ?>/unpaid/download/<?= $DIVISION . "/" . str_replace('.', '__', urlencode($file)) ?>"
                                            data-filename="<?= htmlspecialchars($file) ?>">
                                            Télécharger <i class="fas fa-download"></i>
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>

</div>

<script>
    document.addEventListener('click', async function(e) {

        const button = e.target.closest('.btn-download');

        if (!button) {
            return;
        }

        const url = button.dataset.url;
        const filename = button.dataset.filename;

        try {

            button.disabled = true;

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Erreur HTTP : ' + response.status);
            }

            const blob = await response.blob();

            const downloadUrl = window.URL.createObjectURL(blob);

            const a = document.createElement('a');

            a.href = downloadUrl;
            a.download = filename;

            document.body.appendChild(a);

            a.click();

            a.remove();

            window.URL.revokeObjectURL(downloadUrl);

        } catch (error) {

            console.error(error);

            alert('Impossible de télécharger le fichier.');

        } finally {

            button.disabled = false;
        }

    });
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>