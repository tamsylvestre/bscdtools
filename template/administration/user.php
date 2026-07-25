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
        <div class="row p-1">

            <div class="card col-12">
                <form method="post" action="<?= BASE_URL."/administration/update" ?>">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-3">
                                <label>Utilisateur(s)</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control txtFldAssign" vale="sylvestre.tam" disabled>
                                    <input type="hidden" class="form-control txtFldAssign" val="sylvestre.tam"
                                        name="cn">
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text" id="asignbtn"> <i class="fas fa-users"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6 pointer">
                                <div class="form-group">
                                    <label>Profil(s)</label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" name="roles[]"
                                            data-placeholder="Select a State" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;" required>
                                            <?php foreach ($roles as $row ) {?>
                                            <option value="<?= $row['role_id'] ?>"> <?= $row['role_id'] ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <label>_</label>
                                <input type="submit" class="btn btn-info btn-block" value="ENREGISTRER">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class='card col-12'>
                <div class="card-head">
                </div>
                <div class='card-body'>

                    <table id="example1" class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th style="width: 70%;">Roles</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $row ) {?>
                            <tr>
                                <td> <?= $row->cn ?> </td>
                                <td> 
                                    <?php foreach ($row->roles as $role ) {?>
                                        <span class="badge badge-info"><?= $role['role'] ?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a class="btn btn-outline-info btn-sm mx-1"
                                        href="<?= BASE_URL ?>/administration/userdetail/<?= str_replace(".","_",$row->cn) ?>">
                                        <i class="fas fa-pen"></i>
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