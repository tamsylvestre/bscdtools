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
                                <th>unit</th>
                                <th>name</th>
                                <th>email</th>
                                <th>status</th>
                                <th>roles</th>
                                <th>CreatedAt</th>
                                <th>Last_login_at</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $row ) {?>
                            <tr>
                                <td> <?= $row["unit"] ?> </td>
                                <td> <?= $row["name"] ?> </td>
                                <td> <?= $row["email"] ?> </td>
                                <td> <?= $row["status"] ?> </td>
                                <td> <?= $row["roles"] ?> </td>
                                <td> <?= $row["createdAt"] ?> </td>
                                <td> <?= $row["last_login_at"] ?> </td>
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