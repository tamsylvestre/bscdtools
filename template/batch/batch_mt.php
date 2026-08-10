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

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">CHECKS</h3>
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
                                        <span class="time"><i class="fas fa-clock text-success"></i> 12:05</span>
                                        <span class="time"><i class="fas fa-clock text-dark"></i> 12:05</span>
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
                                                <input type="date" class="form-control" name="annee" value="<?= date('Y-m-d') + 1 ?>">
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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">RAPPORTS</h3>
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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc300-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc300-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport MT</a> </h3>

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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc300-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc300-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport GBT</a> </h3>

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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc510-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc510-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport GBT</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_lecc510">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_lecc510">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_lecc510">-</span> <br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_lecc510">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id='load_div_lecc510'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'lecc510','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'lecc510')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc510')"> <i class='fas fa-eye'></i> </a>
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

                <div class="col-6">

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

                    <div class="card mt-1 invisible" style="height: 85vh;y-overflow:scroll;">
                        <div class="card-header p-2">
                            <h3 class="card-title">
                                <span class="fas fa-circle text-danger"></span>
                                <span class="fas fa-circle text-warning"></span>
                                <span class="fas fa-circle text-success"></span>
                                RETOUR SERVEUR
                            </h3>
                            <div class="card-tools">
                                <!-- <span class="fas fa-circle text-primary" id="status-dot"></span> -->
                                <span class="mr-1" id="status-text">votre serveur.com</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <textarea name="" id="output" class="w-100 h-100 bg-dark text-white" rows="20" disabled></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-3">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">BATCH</h3>
                        </div>

                        <div class="card-body">
                            <div class="timeline">

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc250-enddate"></i> --:-- </span>
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc250-startdate"></i> --:-- </span>
                                        <h3 class="timeline-header"> <a href="#">LECC250</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc250' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(33,'lecc250','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(33,'lecc250')">Kill</a>
                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <i class="fas fa-circle bg-dark"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">BATCH MT</h3>
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
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc250-enddate"></i> --:-- </span>
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc250-startdate"></i> --:-- </span>
                                        <h3 class="timeline-header"> <a href="#">CHECKS</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc250' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(33,'lecc250','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(33,'lecc250')">Kill</a>
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
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc300-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc300-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport MT</a> </h3>

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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc300-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc300-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport GBT</a> </h3>

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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc510-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc510-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport GBT</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_lecc510">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_lecc510">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_lecc510">-</span> <br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_lecc510">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id='load_div_lecc510'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'lecc510','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'lecc510')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc510')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc600-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc600-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">LECC600</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_lecc600">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_lecc600">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_lecc600">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_lecc600">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_lecc600">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'lecc600','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'lecc600')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc600')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc540-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc540-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">LECC540</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_lecc540">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_lecc540">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_lecc540">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_lecc540">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_lecc540">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'lecc540','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc540')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="calcsmo-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="calcsmo-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">CALCSMO</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_calcsmo">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_calcsmo">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_calcsmo">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_calcsmo">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_calcsmo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'calcsmo','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'calcsmo')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('calcsmo')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="estimation-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="estimation-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">ESTIMATION</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_estimation">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_estimation">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_estimation">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_estimation">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_estimation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'estimation','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'estimation')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('estimation')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item bg-secondary">
                                        <span class="time"><i class="fas fa-clock text-success" id="facc_cb_prod-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="facc_cb_prod-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">FACC000-CB-STPROD</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_facc_cb_prod' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'facc_cb_prod','')">Start</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="facc000-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="facc000-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">FACC000</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_facc000">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_facc000">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_facc000">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_facc000">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_facc000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'facc000','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'facc000')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('facc000')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="os_anomalia-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="os_anomalia-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Os_anomalia </a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">

                                                <div class="float-right" style="margin-left:auto;" id="load_div_os_anomalia">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'os_anomalia','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'os_anomalia')">Kill</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="campania-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="campania-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#"> Campania</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">

                                                <div class="float-right" style="margin-left:auto;" id="load_div_campania">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'campania','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'campania')">Kill</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="cb_split-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="cb_split-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Cb_split</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_cb_split">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_cb_split">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_cb_split">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_cb_split">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_cb_split">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'cb_split','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'cb_split')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('cb_split')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="cb_conv-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="cb_conv-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Cb_conv</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_cb_conv">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_cb_conv">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_cb_conv">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_cb_conv">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_cb_conv">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'cb_conv','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'cb_conv')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('cb_conv')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="cb_stprod-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="cb_stprod-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Cb_Stprod</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_cb_stprod">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_cb_stprod">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_cb_stprod">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_cb_stprod">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_cb_stprod">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'cb_stprod','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'cb_stprod')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('cb_stprod')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="cb_stext-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="cb_stext-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Cb_Stext</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_cb_stext">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_cb_stext">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_cb_stext">-</span><br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_cb_stext">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id="load_div_cb_stext">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'cb_stext','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'cb_stext')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('cb_stext')"> <i class='fas fa-eye'></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-circle bg-dark"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">BATCH GBT</h3>
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
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc250-enddate"></i> --:-- </span>
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc250-startdate"></i> --:-- </span>
                                        <h3 class="timeline-header"> <a href="#">CHECKS</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">

                                                </div>

                                                <div class="float-right" id='load_div_lecc250' style="margin-left:auto;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(33,'lecc250','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(33,'lecc250')">Kill</a>
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
                                    <i class="fas fa-cogs bg-secondary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc300-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc300-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport MT</a> </h3>

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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc300-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc300-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport GBT</a> </h3>

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
                                        <span class="time"><i class="fas fa-clock text-success" id="lecc510-enddate">--:--</i> </span>
                                        <span class="time"><i class="fas fa-clock text-dark" id="lecc510-startdate">--:--</i> </span>
                                        <h3 class="timeline-header"> <a href="#">Rapport GBT</a> </h3>

                                        <div class="timeline-body">
                                            <div class="flex" style="display:flex; align-items:center; gap:16px;">
                                                <div class="float-left">
                                                    <i class="fas fa-clock text-dark"> Start : </i>
                                                    <span class="emphasis" id="st_lecc510">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> . End : </i>
                                                    <span class="emphasis" id="end_lecc510">-</span> <br>
                                                    <i class="fas fa-clock text-dark"> Process : </i>
                                                    <span class="text-bold text-md text-success" id="pr_lecc510">-</span> <br>
                                                    <i class="fas fa-eye text-info"> </i>
                                                    <span class="text-bold text-md text-info" id="check_lecc510">-</span>
                                                </div>

                                                <div class="float-right" style="margin-left:auto;" id='load_div_lecc510'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm" onclick="startExecution(162,'lecc510','')">Start</a>
                                            <a class="btn btn-danger btn-sm ml-auto" onclick="kill(162,'lecc510')">Kill</a>
                                            <a class="btn btn-info  btn-sm ml-auto" onclick="check('lecc510')"> <i class='fas fa-eye'></i> </a>
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
        </div>r
    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>
<script src="<?= BASE_URL ?>/template/dist/js/batch.js"></script>