<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SMARTCASH USER LIST</h1>
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
                                <th>Id</th>
                                <th>STATUT</th>
                                <th>Region</th>
                                <th>Division</th>
                                <th>Agence</th>
                                <th>Login</th>
                                <th>Username</th>
                                <th>Profil</th>
                                <th>Last connexion</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $row ) {?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td> <?= $row["STATUT"] ?> </td>
                                <td> <?= $row["Region"] ?> </td>
                                <td> <?= $row["Division"] ?> </td>
                                <td> <?= $row["Agence"] ?> </td>
                                <td> <?= $row["Login"] ?> </td>
                                <td> <?= $row["Username"] ?> </td>
                                <td> <?= $row["Profil"] ?> </td>
                                <td> <?= $row["Last connexion"] ?> </td>
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

<?php require('layout.php') ?>