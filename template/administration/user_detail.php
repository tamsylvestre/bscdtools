<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Administration</h1>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <i class="fas fa-user fa-10x"></i>
                            </div>

                            <h3 class="profile-username text-center"> <?= $cn ?></h3>

                            <p class="text-muted text-center">.</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Profile(s)</b> <a class="float-right">0</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Extraction</b> <a class="float-right">0</a>
                                </li>
                                <li class="list-group-item">
                                    <b>.</b> <a class="float-right">.</a>
                                </li>
                            </ul>

                            <a href="<?= BASE_URL ?>/administration/deleteuser/<?= $cn ?>" class="btn btn-outline-danger btn-block"><b>SUPRIMMER</b></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-9">
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th style="width: 70%;">Roles</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($roles as $row ) {?>
                            <tr>
                                <td> <?= $row["role"] ?> </td>
                                <td>
                                    <a class="btn btn-outline-info btn-sm mx-1"
                                        href="<?= BASE_URL ?>/administration/deleterole/<?= $cn."/".$row['role'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>