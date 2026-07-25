<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> ANNULATION BT & MT </h1>
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
                <form method="post" action="<?= BASE_URL ?>/cms/annulation">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-3">
                            </div>

                            <div class="form-group col-5 pointer">
                                <label> <code> Choisir la période : </code> </label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation" name="periode">
                                </div>
                            </div>

                            <div class="col-3">
                                <label>_</label>
                                <input type="submit" class="btn btn-info btn-block" value="EXTRACT">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class=" col-10 mx-auto">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Période : <?= $periode ?> </h3>
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
                            foreach ($annulations as $file ) {
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

                    <div class="card-footer text-right">
                        <span class="lead"> <?= $output ?> </span>
                    </div>

                </div>


            </div>

        </div>
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>