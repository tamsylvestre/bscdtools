<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Historique Achat compteur </h1>
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

            <div class="card col-11 mx-auto">
                <form method="post" action="<?= BASE_URL ?>/powernet/buyhisto">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-3">
                                <label> <code> Compteur : </code> </label>
                                <input type="text" class="form-control float-right" name="compteur">
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

            <div class=" col-12 mx-auto">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Période : <?= $periode ?> </h3>
                    </div>


                    <div class="card-body">
                        <table id="example1" class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>ORDERSID</th>
                                    <th>METERNO</th>
                                    <th>CONTRACT</th>
                                    <th>CUSTOMER_NAME</th>
                                    <th>POS</th>
                                    <th>TOKEN</th>
                                    <th>MONTH</th>
                                    <th>YEAR</th>
                                    <th>OP_TIME</th>
                                    <th>ENERGY</th>
                                    <th>TENDERAMT</th>
                                    <th>COMPANY_TENDERAMT</th>
                                    <th>CHARGE_AMOUNT</th>
                                    <th>COMPANY_CHARGE_AMOUNT</th>
                                    <th>TOTAL_AMOUNT</th>
                                    <th>COMPANY_ACCOUNT_ID</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($achats as $row ) {?>
                                <tr>
                                    <td><?= $row["ORDERSID"] ?></td>
                                    <td><?= $row["METERNO"] ?></td>
                                    <td><?= $row["CONTRACT"] ?></td>
                                    <td><?= $row["CUSTOMER_NAME"] ?></td>
                                    <td><?= $row["POS"] ?></td>
                                    <td><?= $row["TOKEN"] ?></td>
                                    <td><?= $row["MONTH"] ?></td>
                                    <td><?= $row["YEAR"] ?></td>
                                    <td><?= $row["OP_TIME"] ?></td>
                                    <td><?= $row["ENERGY"] ?></td>
                                    <td><?= $row["TENDERAMT"] ?></td>
                                    <td><?= $row["COMPANY_TENDERAMT"] ?></td>
                                    <td><?= $row["CHARGE_AMOUNT"] ?></td>
                                    <td><?= $row["COMPANY_CHARGE_AMOUNT"] ?></td>
                                    <td><?= $row["TOTAL_AMOUNT"] ?></td>
                                    <td><?= $row["COMPANY_ACCOUNT_ID"] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>

        </div>
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>