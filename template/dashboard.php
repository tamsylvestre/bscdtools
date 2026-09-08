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
                            <li><a href="<?= BASE_URL ?>/cms/customer_list" target="_blank"> Customer List </a></li>
                            
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
                            <li><a href="<?= BASE_URL ?>/batch/historique/0" target="_blank"> Historique BATCH </a></li>
                            <li><a href="<?= BASE_URL ?>/batch/copy_mms" target="_blank"> Copie MMS >>> CMS </a></li>
                            <li><a href="<?= BASE_URL ?>/batch/batch_mt" target="_blank"> Facturation MT & GBT </a></li>                          
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

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            IMPAYÉS
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
                    <div class="card-body">
                        <ol>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DCUD" target="_blank"> DCUD </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DCUY" target="_blank"> DCUY </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRC" target="_blank"> DRC </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRE" target="_blank"> DRE </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRNEA" target="_blank"> DRNEA </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRONO" target="_blank"> DRONO </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRSANO" target="_blank"> DRSANO </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRSM" target="_blank"> DRSM </a></li>
                            <li><a href="<?= BASE_URL ?>/unpaid/files/DRSOM" target="_blank"> DRSOM </a></li>
                            
                        </ol>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>