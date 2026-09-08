<?php ob_start(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">COPY MMS TO CMS</h1>
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

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">CHECKS</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body box-profile">
                            <span class="btn btn-info btn-block" onclick="startExecution('33','Cfechab','')"><b>CHECK-FECHAB</b></span><br>
                            <span class="btn btn-info btn-block" onclick="startExecution(33,'run_check_batchs','')"><b>RUN-CHECK-BATCHS</b></span><br>
                            <span class="btn btn-info btn-block" onclick="startExecution('33','Cfechab','')"><b>CONFIG.INI</b></span>
                        </div>
                    </div>

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title"> CONFIG </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="timeline">

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">CYCLE</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:1px;">
                                                <div class="float-left">
                                                    <input type="number" class="form-control" id="inp_fechab" value="<?= date('m') - 1 ?>">
                                                </div>

                                                <div class="float-right" style="margin-left:auto;">
                                                    <span class="btn btn-warning btn-sm" onclick="change_fechab()"> Change </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">FECHAB BIN_AMR</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:1px;">
                                                <div class="float-left">
                                                    <input type="date" class="form-control" id="inp_fechab" value="<?= date('Y-m-d') ?>">
                                                </div>

                                                <div class="float-right" style="margin-left:auto;">
                                                    <span class="btn btn-warning btn-sm" onclick="change_fechab()"> Change </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">Config.ini</a> </h3>

                                        <div class="timeline-body">
                                            <div class="form-group">
                                                <label for=""> <code>start</code></label>
                                                <input type="date" class="form-control" name="annee" value="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for=""> <code>end</code></label>
                                                <input type="date" class="form-control" name="annee" value="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for=""> <code>last try</code></label>
                                                <input type="number" class="form-control" name="annee" value="0">
                                            </div>
                                            <a class="btn btn-info btn-block" onclick="">LAUNCH</a>
                                        </div>
                                        <div class="timeline-footer">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">Anomalies MT</a> </h3>

                                        <div class="timeline-body">

                                            <div class="form-group">
                                                <label for="exampleInputFile"> <code>upload csv</code></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="ref" class="custom-file-input" id="exampleInputFile"
                                                            accept=".xlsx" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text btn">Upload</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile"> <code>Ajouter compteur</code></label>
                                                <div class="input-group input-group-md">
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <span class="btn btn-info btn-sm" onclick=""> <i class="fas fa-eye"></i> </span>
                                                <span class="btn btn-warning btn-sm" onclick=""> <i class="fas fa-download"></i> </span>
                                            </div>

                                        </div>
                                        <div class="timeline-footer">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-6">


                    <div class="card">
                    
                        <table class='table text-md'>
                            <thead>
                                <tr>
                                    <th>CYLCLE ACTUEL</th>
                                    <th>DATE COPIE(FECHAB)</th>
                                    <th>CONFIGURATION COPIE(config.ini)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>8</td>
                                    <td> 20260807 </td>
                                    <td>
                                        fromDate=2026-08-25 <br>
                                        toDate=2026-09-03 <br>
                                        lastTryMv=1 <br>
                                        lastTryLv=1 <br>
                                        threads=4 <br>
                                        closePending=0 <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="terminal">
                        <div class="terminal-bar">
                            <div class="dots">
                                <div class="dot r"></div>
                                <div class="dot y"></div>
                                <div class="dot g"></div>
                            </div>
                            <div class="server-label">
                                <div id="status-dot"></div>
                                <span id="server-name">BACTH SERVEUR</span>
                            </div>
                        </div>

                        <div class="terminal-output" id="output1">
                            <div class="line info">
                                <span class="prompt">$</span>
                                <span class="line-text">Prêt. Cliquez sur <strong>start</strong> pour lancer un script batch.</span>
                            </div>
                            <div class="line log"><span class="cursor0"></span></div>
                        </div>
                    </div>

                    <div class="card mt-3" style=" overflow-x : scroll">

                        <div class="card-header">
                            <h3 class="card-title">RAPPORT</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <table class='table table-striped text-xs'>
                            <thead>
                                <tr>
                                    <th> N° Migration </th>
                                    <th> Client </th>
                                    <th>Compt. avant Migration </th>
                                    <th>Compt. Lu </th>
                                    <th>Compt. après migration </th>
                                    <th>Itin. avant Migration </th>
                                    <th>Itin. Fermé auto. </th>
                                    <th>Itin. Fermé manu. </th>
                                    <th>Total Itin. Fermé </th>
                                    <th>Itin. en attente </th>
                                    <th>Taux d'avancement </th>
                                    <th>Taux évolution </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i=1; while($i<=4) {  ?>
                                <tr>
                                    <td> <?= $i ?> </td>
                                    <td> MT </td>
                                    <td> 2601 </td>
                                    <td> 2082 </td>
                                    <td> 519 </td>
                                    <td> 2607 </td>
                                    <td> 2076 </td>
                                    <td> 0 </td>
                                    <td> 2076 </td>
                                    <td> 531 </td>
                                    <td> 80% </td>
                                    <td> 90% </td>
                                </tr>
                                <tr>
                                    <td> <?= $i ?> </td>
                                    <td> GBT </td>
                                    <td> 43039 </td>
                                    <td> 37304 </td>
                                    <td> 5735 </td>
                                    <td> 1509 </td>
                                    <td> 115 </td>
                                    <td> 327 </td>
                                    <td> 442 </td>
                                    <td> 1067 </td>
                                    <td> 87% </td>
                                    <td> 89% </td>
                                </tr>
                                <?php $i++; } ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-3">

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">COPIE MT</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="timeline">

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">Itineraire</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc250' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary  btn-sm ml-auto" onclick=""> <i class='fas fa-unlock'></i> </a>
                                            <a class="btn btn-danger  btn-sm ml-auto" onclick=""> <i class='fas fa-lock'></i> </a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc510')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">LECC250</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc300' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="">Kill</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">Block Ano. MT</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc300' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="">Run</a>
                                            <a class="btn btn-INFO btn-sm ml-auto" onclick=""><i class='fas fa-eye'></i></a>
                                        </div>
                                    </div>
                                </div>

                                
                                <div>
                                    <i class="fas fa-circle bg-dark"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">COPIE GBT</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="timeline">

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">Itineraire</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc250' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary  btn-sm ml-auto" onclick=""> <i class='fas fa-unlock'></i> </a>
                                            <a class="btn btn-danger  btn-sm ml-auto" onclick=""> <i class='fas fa-lock'></i> </a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc510')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">SPLIT</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:1px;">
                                                <div class="float-left">
                                                    <input type="number" class="form-control" id="inp_fechab" value="7">
                                                </div>

                                                <div class="float-right" style="margin-left:auto;">
                                                    <span class="btn btn-warning btn-sm" onclick="change_fechab()"> SPLIT </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">LECC250</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc300' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="">Kill</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"> <a href="#">Close Manual Itin. GBT</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc300' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="">Kill</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-circle bg-dark"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>
<script src="<?= BASE_URL ?>/template/dist/js/batch.js"></script>