<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> ACI Créé dans ICN CASHING </h1>
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
                <form method="post" action="<?= BASE_URL ?>/icn/aci_brute">
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

            <div class=" col-12 mx-auto">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-titl"> <?= $periode ?> </h3>
                    </div>


                    <div class="card-body">
                        <table id="example1" class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>reference</th>
                                    <th>name</th>
                                    <th>region</th>
                                    <th>unit</th>
                                    <th>status</th>
                                    <th>reasonForRefusal</th>
                                    <th>bank</th>
                                    <th>branch</th>
                                    <th>town</th>
                                    <th>amount</th>
                                    <th>paymentDate</th>
                                    <th>paymentMode</th>
                                    <th>createdAt</th>
                                    <th>updatedAt</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($acis as $aci ) {?>
                                <tr>
                                    <td> <?= $aci['reference'] ?> </td>
                                    <td> <?= $aci['name'] ?> </td>
                                    <td> <?= $aci['region'] ?> </td>
                                    <td> <?= $aci['unit'] ?> </td>
                                    <td> <?= $aci['status'] ?> </td>
                                    <td> <?= $aci['reasonForRefusal'] ?> </td>
                                    <td> <?= $aci['bank'] ?> </td>
                                    <td> <?= $aci['branch'] ?> </td>
                                    <td> <?= $aci['town'] ?> </td>
                                    <td> <?= $aci['amount'] ?> </td>
                                    <td> <?= $aci['paymentDate'] ?> </td>
                                    <td> <?= $aci['paymentMode'] ?> </td>
                                    <td> <?= $aci['createdAt'] ?> </td>
                                    <td> <?= $aci['updatedAt'] ?> </td>
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

<?php require('layout.php') ?>