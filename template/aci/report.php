<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rapport ACI DFI</h1>
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
        <div class="row p-1">

            <div class="card col-12">
                <form method="post" action="<?= BASE_URL."/aci/report" ?>" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-4 pointer">
                                <label for="exampleInputFile"> <code>Referentiel SAP</code></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="ref" class="custom-file-input" id="exampleInputFile"
                                            accept=".xlsx" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append invisible">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-4">
                                <label>Date Création ACI :</label>
                                <input type="date" class="form-control" name="dateCreation" required />
                            </div>

                            <div class="col-3">
                                <label class="text-white">_</label>
                                <input type="submit" class="btn btn-info btn-block" value="EXTRACT">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title"> ACI créés et non comptabilisés dans SAP ( ICN-SAP ) </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body">
                    <table class='table table-striped' id="exemple1">
                        <thead>
                            <tr>
                                <th style="width: 10%;"></th>
                                <th class="text-center"> Fichier </th>
                                <th style="width: 10%;"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            foreach ($creatednotaccounted as $file ) {
                                $tab = explode("/",$file);
                            ?>
                            <tr>
                                <td> <i class="fas fa-file fa-2x"></i> </td>
                                <td class="lead text-center"> <?= $tab[sizeof($tab)-1] ?> </td>
                                <td>
                                    <a href="<?= BASE_URL."/template/exports/annulations/".$tab[sizeof($tab)-1] ?>"
                                        target="_blank" rel="noopener noreferrer" class="btn btn-outline-info">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title"> ACI créés et non encaissés dans SAP </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body">

                </div>

            </div>

            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title"> ACI encaissés et non intégrés dans SAP </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body">

                </div>

            </div>

            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title"> ACI comptabilisés dans SAP mais non créés dans ICN CASHING </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body">

                </div>

            </div>

            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title"> anomalies d’intégration lors des transferts d’encaissements des ACI </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body">

                </div>

            </div>

        </div>
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>