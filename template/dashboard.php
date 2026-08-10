<?php ob_start(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">BSCD TOOLS </h1>
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            CMS
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol>
                            <li><a href="<?= BASE_URL ?>/cms/users" target="_blank"> Liste des utilisateurs </a></li>
                            <li><a href="<?= BASE_URL ?>/cms/asc" target="_blank"> Extraction ASC  </a></li>
                            <li><a href="<?= BASE_URL ?>/cms/annulation" target="_blank"> Annulation BT et MT </a></li>
                            <li><a href="<?= BASE_URL ?>/cms/aci_encaisses" target="_blank"> ACI intégré </a></li>
                            
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            SMARTCASH
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol>
                            <li><a href="<?= BASE_URL ?>/smartcash/users" target="_blank"> Liste des utilisateurs </a></li>
                            <li><a href="<?= BASE_URL ?>/smartcash/rapporttparties" target="_blank"> Rapport Thirdparties </a> </li>
                            
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            ICN CASHING
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol>
                            <li><a href="<?= BASE_URL ?>/icn/users" target="_blank"> Liste des utilisateurs </a> </li>
                            <li> <a href="<?= BASE_URL ?>/icn/aci_brute" target="_blank"> ACI créé dans ICN </a> </li>
                            <li> <a href="<?= BASE_URL ?>/icn/unapplied_aci" target="_blank"> ACI créé dans ICN non intégré </a> </li>
                            <li> <a href="<?= BASE_URL ?>/icn/cancel_aci" target="_blank"> Annulé un ACI </a> </li>
                            
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            FACTURATION
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol>
                            <li><a href="<?= BASE_URL ?>/batch" target="_blank"> BATCH BT </a></li>
                            <li><a href="<?= BASE_URL ?>/batch/historique/0" target="_blank"> Historique BATCH BT </a></li>
                            <li><a href="<?= BASE_URL ?>/batch/batch_mt" target="_blank"> BATCH GBT & MT </a></li>                          
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            POWERNET
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol>
                            <li> <a href="<?= BASE_URL ?>/powernet/users" target="_blank"> Liste des utilisateurs </a> </li>
                            <li> <a href="<?= BASE_URL ?>/powernet/saleslogs" target="_blank"> Journaux de ventes des partenaires </a> </li>
                            <li> <a href="<?= BASE_URL ?>/powernet/buyhisto" target="_blank"> Historique des achats compteurs </a> </li>
                            
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            MRA
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ol>
                            <li><a href="http://" target="_blank"> Liste des utilisateurs </a></li>
                            
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <!-- <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-users"></i>
                    </div>
                    <div class="inner">
                        <h3>SMARTCASH</h3>

                        <p>User List</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/smartcash/users" class="small-box-footer">
                        SMARTCASH <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3> ICN </h3>
                        <p>User List</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/icn/users" class="small-box-footer">
                        ICN Cashing <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3> CMS </h3>
                        <p>User List</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/cms/users" class="small-box-footer">
                        CMS <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3> ASC </h3>
                        <p>ASC & Miscalenous </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/cms/asc" class="small-box-footer">
                        CMS <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-users"></i>
                    </div>
                    <div class="inner">
                        <h3>BT & MT</h3>

                        <p>ANNULATION</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/cms/annulation" class="small-box-footer">
                        CMS <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-users"></i>
                    </div>
                    <div class="inner">
                        <h3>MEMOIRE</h3>

                        <p>Mémoires et Données mémoires</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/dashboard" class="small-box-footer">
                        CMS & POWERNET <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-users"></i>
                    </div>
                    <div class="inner">
                        <h3>POWERNET</h3>

                        <p>Users List</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/powernet/users" class="small-box-footer">
                        POWERNET <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-users"></i>
                    </div>
                    <div class="inner">
                        <h3>ACI</h3>

                        <p>Encaissés dans CMS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/cms/aci_encaisses" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-money"></i>
                    </div>
                    <div class="inner">
                        <h3>ACI</h3>

                        <p>Créé dans ICN Cashing</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/icn/aci_brute" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-money"></i>
                    </div>
                    <div class="inner">
                        <h3> POWERNET </h3>

                        <p> Journaux de ventes des partenaires </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/powernet/saleslogs" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-money"></i>
                    </div>
                    <div class="inner">
                        <h3>ACI</h3>

                        <p>Créé dans ICN Cashing Non Encaissés dans CMS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/icn/unapplied_aci" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-money"></i>
                    </div>
                    <div class="inner">
                        <h3>POWERNET</h3>

                        <p>Historique des achats compteurs</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/powernet/buyhisto" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-money"></i>
                    </div>
                    <div class="inner">
                        <h3>ACI RAPPORT DFI</h3>

                        <p>Rapport ACI pour GERMAINE</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/aci/report" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="overlay invisible">
                        <i class="fas fa-3x fa-money"></i>
                    </div>
                    <div class="inner">
                        <h3>BATCH EXECUTION</h3>

                        <p>Execution du batch de facturation</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= BASE_URL ?>/batch" class="small-box-footer">
                        VIEW <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div> -->

        </div>

    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>