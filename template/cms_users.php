<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CMS USER LIST</h1>
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
        <div class="row ox_scroll">

            <div class='card col-12'>
                <div class='card-body'>

                    <table id="example1" class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>NOM_AREA</th>
                                <th>NOM_ZONA</th>
                                <th>COD_UNICOM</th>
                                <th>NOM_UNICOM</th>
                                <th>NOM_USR</th>
                                <th>DESC_USR</th>
                                <th>NOM_PERFIL</th>
                                <th>DESC_PERFIL</th>
                                <th>SECOND_PROFILE</th>
                                <th>AUX_SEC_PROFILE_1</th>
                                <th>AUX_SEC_PROFILE_2</th>
                                <th>AUX_SEC_PROFILE_3</th>
                                <th>AUX_SEC_PROFILE_4</th>
                                <th>AUX_SEC_PROFILE_5</th>
                                <th>LAST_MODIFICATION_DATE</th>
                                <th>CREATION_DATE</th>
                                <th>CREATION_BY</th>
                                <th>LAST_CHANGED_PASSWORD</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $row ) {?>
                            <tr>
                                <td><?= $row["NOM_AREA"] ?></td>
                                <td> <?= $row["NOM_ZONA"] ?> </td>
                                <td> <?= $row["COD_UNICOM"] ?> </td>
                                <td> <?= $row["NOM_UNICOM"] ?> </td>
                                <td> <?= $row["NOM_USR"] ?> </td>
                                <td> <?= $row["DESC_USR"] ?> </td>
                                <td> <?= $row["NOM_PERFIL"] ?> </td>
                                <td> <?= $row["DESC_PERFIL"] ?> </td>
                                <td> <?= $row["SECOND_PROFILE"] ?> </td>
                                <td> <?= $row["AUX_SEC_PROFILE_1"] ?> </td>
                                <td> <?= $row["AUX_SEC_PROFILE_2"] ?> </td>
                                <td> <?= $row["AUX_SEC_PROFILE_3"] ?> </td>
                                <td> <?= $row["AUX_SEC_PROFILE_4"] ?> </td>
                                <td> <?= $row["AUX_SEC_PROFILE_5"] ?> </td>
                                <td> <?= $row["LAST_MODIFICATION_DATE"] ?> </td>
                                <td> <?= $row["CREATION_DATE"] ?> </td>
                                <td> <?= $row["CREATION_BY"] ?> </td>
                                <td> <?= $row["LAST_CHANGED_PASSWORD"] ?> </td>
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