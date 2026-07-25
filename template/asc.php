<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ASC & Miscalenous</h1>
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

            <div class="card col-12">
                <form method="post" action="?action=asc" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-3 pointer">
                                <label for="exampleInputFile"> <code>Referentiel</code></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="ref" class="custom-file-input" id="exampleInputFile"
                                            accept=".xlsx" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append invisible">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-3 pointer">
                                <label for="exampleSelectBorder"><code>cycle</code></label>
                                <select class="custom-select form-control-border" name="cycle" id="exampleSelectBorder">
                                    <option value="1"> 1</option>
                                    <option value="2"> 2</option>
                                    <option value="3"> 3</option>
                                    <option value="4"> 4</option>
                                    <option value="5"> 5</option>
                                    <option value="6"> 6</option>
                                    <option value="7"> 7</option>
                                    <option value="8"> 8</option>
                                    <option value="9"> 9</option>
                                    <option value="10"> 10</option>
                                    <option value="11"> 11</option>
                                    <option value="12"> 12</option>
                                </select>
                            </div>

                            <div class="form-group col-3 pointer">
                                <label for=""> <code>année</code></label>
                                <input type="number" class="form-control" name="annee" value="2026">
                            </div>

                            <div class="col-3">
                                <label>_</label>
                                <input type="submit" class="btn btn-info btn-block" value="EXTRACT">
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
                                <th>SERVICE_NO</th>
                                <th>CUST_NAME</th>
                                <th>AGENCY</th>
                                <th>READING_CYCLE</th>
                                <th>REGROUP_ID</th>
                                <th>REGROUP_NAME</th>
                                <th>CALENDAR_YEAR</th>
                                <th>OLD_ACCOUNT_NO</th>
                                <th>METER_NO</th>
                                <th>NUMBER_WIRES</th>
                                <th>SUBSCRIPTION_LOAD</th>
                                <th>BILLING_DATE</th>
                                <th>BILLING_DATE</th>
                                <th>DISPATCH_DATE</th>
                                <th>AMOUNT_WITH_TAX</th>
                                <th>DUE_AMOUNT</th>
                                <th>BILL_STATUS</th>
                                <th>CAT_CLI</th>
                                <th>AMOUNT_WITHOUT_VAT</th>
                                <th>AMOUNT_VAT</th>
                                <th>BILL_TYPE</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($asc as $row ) {?>
                            <tr>
                                <td> <?= $row['SERVICE_NO'] ?> </td>
                                <td> <?= $row['CUST_NAME'] ?> </td>
                                <td> <?= $row['AGENCY'] ?> </td>
                                <td> <?= $row['READING_CYCLE'] ?> </td>
                                <td> <?= $row['REGROUP_ID'] ?> </td>
                                <td> <?= $row['REGROUP_NAME'] ?> </td>
                                <td> <?= $row['CALENDAR_YEAR'] ?> </td>
                                <td> <?= $row['OLD_ACCOUNT_NO'] ?> </td>
                                <td> <?= $row['METER_NO'] ?> </td>
                                <td> <?= $row['NUMBER_WIRES'] ?> </td>
                                <td> <?= $row['SUBSCRIPTION_LOAD'] ?> </td>
                                <td> <?= $row['BILLING_DATE'] ?> </td>
                                <td> <?= $row['BILLING_DATE'] ?> </td>
                                <td> <?= $row['DISPATCH_DATE'] ?> </td>
                                <td> <?= $row['AMOUNT_WITH_TAX'] ?> </td>
                                <td> <?= $row['DUE_AMOUNT'] ?> </td>
                                <td> <?= $row['BILL_STATUS'] ?> </td>
                                <td> <?= $row['CAT_CLI'] ?> </td>
                                <td> <?= $row['AMOUNT_WITHOUT_VAT'] ?> </td>
                                <td> <?= $row['AMOUNT_VAT'] ?> </td>
                                <td> <?= $row['BILL_TYPE'] ?> </td>
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