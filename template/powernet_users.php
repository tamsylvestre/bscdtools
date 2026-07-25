<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">POWERNET USER LIST</h1>
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
                                <th>ACCOUNT_STATUS</th>
                                <th>CZYID</th>
                                <th>DWDM</th>
                                <th>XM</th>
                                <th>MM</th>
                                <th>ZT</th>
                                <th>SJHM</th>
                                <th>DHHM</th>
                                <th>CJRQ</th>
                                <th>BDIP</th>
                                <th>BDMAC</th>
                                <th>SYSJQ</th>
                                <th>SYSJZ</th>
                                <th>YXDZ</th>
                                <th>TXFWS</th>
                                <th>MMCWCS</th>
                                <th>XTID</th>
                                <th>MMXGSJ</th>
                                <th>MMGQTS</th>
                                <th>YZMCJSJ</th>
                                <th>YZM</th>
                                <th>QZXGMMBZ</th>
                                <th>MMTSXX</th>
                                <th>ZHGQSJ</th>
                                <th>DLIP</th>
                                <th>CJR</th>
                                <th>ZJDLSJ</th>
                                <th>JJDLYY</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $row ) {?>
                            <tr>
                                <td> <?= $row["ACCOUNT_STATUS"] ?> </td>
                                <td> <?= $row["CZYID"] ?> </td>
                                <td> <?= $row["DWDM"] ?> </td>
                                <td> <?= $row["XM"] ?> </td>
                                <td> <?= $row["MM"] ?> </td>
                                <td> <?= $row["ZT"] ?> </td>
                                <td> <?= $row["SJHM"] ?> </td>
                                <td> <?= $row["DHHM"] ?> </td>
                                <td> <?= $row["CJRQ"] ?> </td>
                                <td> <?= $row["BDIP"] ?> </td>
                                <td> <?= $row["BDMAC"] ?> </td>
                                <td> <?= $row["SYSJQ"] ?> </td>
                                <td> <?= $row["SYSJZ"] ?> </td>
                                <td> <?= $row["YXDZ"] ?> </td>
                                <td> <?= $row["TXFWS"] ?> </td>
                                <td> <?= $row["MMCWCS"] ?> </td>
                                <td> <?= $row["XTID"] ?> </td>
                                <td> <?= $row["MMXGSJ"] ?> </td>
                                <td> <?= $row["MMGQTS"] ?> </td>
                                <td> <?= $row["YZMCJSJ"] ?> </td>
                                <td> <?= $row["YZM"] ?> </td>
                                <td> <?= $row["QZXGMMBZ"] ?> </td>
                                <td> <?= $row["MMTSXX"] ?> </td>
                                <td> <?= $row["ZHGQSJ"] ?> </td>
                                <td> <?= $row["DLIP"] ?> </td>
                                <td> <?= $row["CJR"] ?> </td>
                                <td> <?= $row["ZJDLSJ"] ?> </td>
                                <td> <?= $row["JJDLYY"] ?> </td>
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