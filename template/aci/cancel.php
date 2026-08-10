<?php ob_start(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">BSCD TOOLS</h1>
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

                <div class="col-3">

                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"> CHECK ACI HERE </h3>
                        </div>
                        <div class="card-body box-profile">

                            <div class="text-center">
                                <i class="fas fa-archive fa-4x"></i>
                            </div>
                            <form action="cancel_aci" method="post">
                                <input type="text" class="form-control" name="reference" placeholder="0102522026" required>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block"><b>CHECK</b></button>
                            </form>

                        </div>
                    </div>

                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"> ACI INFO </h3>
                        </div>
                        <div class="card-body box-profile">

                            <div class="form-group">
                                <label> <code> Reference : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['reference'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Client : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['name'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Montant : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['amount'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Banque : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['bank'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Statu : </code> </label>
                                <input type="text" class="form-control float-right text-bold text-success" value="<?= (sizeof($aci) > 0) ? $aci['status'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Date Payement : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['paymentDate'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Mode Payement : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['paymentMode'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Region : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['region'] : "" ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label> <code> Refusal : </code> </label>
                                <textarea class="form-control" disabled>
                                    <?= (sizeof($aci) > 0) ? $aci['reasonForRefusal'] : "" ?>
                                </textarea>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-9">
                    <p class="display-4 text-info text-center blink ">
                        <?= $error ?>
                    </p>

                    <table id="example1" class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>N° Facture</th>
                                <th>Montant Total</th>
                                <th>Montant Payé</th>
                                <th>Ajouté le</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($aci_details as $item) { ?>
                                <tr>
                                    <td> <?= $item['name'] ?> </td>
                                    <td> <?= $item['invoice'] ?> </td>
                                    <td> <?= $item['amountUnpaid'] ?> </td>
                                    <td> <?= $item['amountTopaid'] ?> </td>
                                    <td> <?= $item['created_at'] ?> </td>
                                </tr>
                            <?php }  ?>
                        </tbody>
                    </table>

                    <hr>

                    <form action="cancel_aci" method="post">
                        <div class="row <?= $visible ?>">
                            <div class="col-3 mx-auto">
                                <label> <code> Reference : </code> </label>
                                <input type="text" class="form-control float-right" value="<?= (sizeof($aci) > 0) ? $aci['reference'] : "" ?>" disabled>
                                <input type="hidden" name='reference' value="<?= (sizeof($aci) > 0) ? $aci['reference'] : "" ?>">

                            </div>
                            <div class="col-5 mx-auto">
                                <label> <code> Motif : </code> </label>
                                <input type="text" class="form-control float-right" name="motif" required>

                            </div>
                            <div class="col-3 mx-auto">
                                <label> . </label>
                                <button type="submint" class="btn btn-block btn-warning text-bold text-white">
                                    <i class="fas fa-trash"></i>
                                    REJETER
                                </button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>r
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>
<script src="<?= BASE_URL ?>/template/dist/js/batch.js"></script>