<?php ob_start(); ?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <div class="pb-2 w-100 text-center text-white">
                <a href="" class="w-100">
                    <img src="template/dist/img/eneo_logo.jpg" alt="Logo" class="brand-image elevation-3" style="width: 100%; opacity: .8">
                    <span class="brand-text font-weight-bold invisible" style="font-size: 20px; opacity: .8">ASSESSOR</span>
                </a>
                <span class="brand-text display-4"> DCP KPI </span>
            </div>
            <div class="divider"></div>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="?action=dashboard" class="nav-link btn_nav_link menu_dashboard menu">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    DASHBOARD
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="?action=graph" class="nav-link btn_nav_link menu_dashboard menu">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    GRAPH
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
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

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3> <?= 00 ?> </h3>

                                    <p>DOMAINES(S)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    _
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3> <?= 00 ?> </h3>

                                    <p>SERVICE(S)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    _
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3> <?= 00 ?> </h3>

                                    <p>INDICATEUR(S)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    _
                                </a>
                            </div>
                        </div>

                        <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3> <?= "ENEO DCP" ?> </h3>

                            <p>_</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-home"></i>
                          </div>
                          <a href="#" class="small-box-footer">
                            _
                          </a>
                        </div>
                      </div> -->

                    </div>

                    <div class="row pt-4">

                        <div class="col-12 p-2">
                            <div class='card'>
                                <div class="card-header">
                                    <h4 class='font-weight-bold text-center'> </h4>
                                </div>
                                <div class='card-body'>

                                    <table class='table table-bordered'>
                                        <thead style='font-size:10px'>
                                            <tr>
                                                <th rowspan="2"> Indicateur </th>
                                                <th rowspan="2"> Unité </th>
                                                <th class='text-center' colspan="3"> MOIS </th>
                                                <th class='text-center' colspan="3"> YTD </th>
                                                <th class='text-center' rowspan="2" style="width:30%"> Commentaire </th>
                                            </tr>
                                            <tr class='text-center'>
                                                <th> Budget </th>
                                                <th> Réalisé </th>
                                                <th> Ecart </th>
                                                <th> Budget </th>
                                                <th> Réalisé </th>
                                                <th> Ecart </th>
                                                <th> BudgetYTD </th>
                                                <th> RéaliséYTD </th>
                                            </tr>
                                        </thead>

                                        <tbody class="fts">
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </section>

        </div>
    </div>
</body>