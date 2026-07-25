<?php ob_start(); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">HISTORIQUE BATCH</h1>
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
                            <h3 class="card-title"> JOURS </h3>
                        </div>
                        <div class="card-body box-profile">

                            <form action="<?= BASE_URL ?>/batch/historique/day" method="post">
                                <input type="date" class="form-control" name="day" value="<?= $day ?>" required>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block"><b>CHECK</b></button>
                            </form>

                        </div>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"> BATCH / JOUR </h3>
                        </div>
                        <div class="card-body box-profile">

                            <form action="<?= BASE_URL ?>/batch/historique/batch_day" method="post">
                                <div class="form-group pointer">
                                    <label for="exampleSelectBorder"> <code>BATCH</code> </label>
                                    <select class="form-control select2 select2-purple"
                                        data-dropdown-css-class="select2-purple"
                                        style="width: 100%;"
                                        name="batch">
                                        <?php foreach ($batch_list as $item) { ?>
                                            <option value="<?= $item['BATCH_NAME'] ?>"><?= $item['BATCH_NAME'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                                <div class="form-group pointer">
                                    <label for=""><code>Période</code></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right reservation" id="reservation0" value="<?= $day1 . "|" . $day2 ?>" name="periode">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block"><b>CHECK</b></button>
                            </form>

                        </div>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"> BATCH / SEMAINE </h3>
                        </div>
                        <div class="card-body box-profile">

                            <form action="<?= BASE_URL ?>/batch/historique/batch_week" method="post">
                                <div class="form-group pointer">
                                    <label for="exampleSelectBorder"> <code>BATCH</code> </label>
                                    <select class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                        <?php foreach ($batch_list as $item) { ?>
                                            <option value="<?= $item['BATCH_NAME'] ?>"><?= $item['BATCH_NAME'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>

                                <div class="form-group pointer">
                                    <label for="exampleSelectBorder"> <code>Semaine 1 </code> </label>
                                    <input type="week" class="form-control" name="reference" required>
                                </div>

                                <div class="form-group pointer">
                                    <label for="exampleSelectBorder"> <code>Semaine 2 </code> </label>
                                    <input type="week" class="form-control" name="reference" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block"><b>CHECK</b></button>
                            </form>

                        </div>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"> FACTURE </h3>
                        </div>
                        <div class="card-body box-profile">

                            <form action="<?= BASE_URL ?>/batch/historique/facture" method="post">

                                <div class="form-group pointer">
                                    <label for="exampleSelectBorder"> <code>Semaine 1 </code> </label>
                                    <input type="week" class="form-control" name="week1" required>
                                </div>

                                <div class="form-group pointer">
                                    <label for="exampleSelectBorder"> <code>Semaine 2 </code> </label>
                                    <input type="week" class="form-control" name="week2">
                                </div>

                                <button type="submit" class="btn btn-primary btn-block"><b>CHECK</b></button>
                            </form>

                        </div>
                    </div>

                </div>

                <div class="col-9">

                    <div class="row <?= $day_graph ?>">

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Durée Totale</span>
                                    <span class="info-box-number">
                                        42 min
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Scripts exécutés</span>
                                    <span class="info-box-number">41</span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Données traitées</span>
                                    <span class="info-box-number">5 426 812</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Statut</span>
                                    <span class="info-box-number">SUCCESS</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 <?= $day_graph ?>">

                            <div class="chart-title">

                                Chronologie des scripts

                            </div>

                            <div id="timeline"></div>

                        </div>

                        <div class="col-4 ml-auto <?= $day_graph ?>">

                            <div class="chart-title">

                                Répartition du temps

                            </div>

                            <div id="donut"></div>

                        </div>

                        <div class="col-12 <?= $batch_day_graph ?>">
                            <p class="text-center display-5">

                            </p>

                            <div class="chart-title">

                                Vitesse d'exécution <b> <?= $batch_day ?> </b> <?= $day1 ?> à <?= $day2 ?>

                            </div>

                            <div id="duration"></div>

                        </div>

                        <!-- <div class="col-12 <?= $batch_week_graph ?>">

                            <div class="chart-title">

                                Enregistrements traités

                            </div>

                            <div id="records"></div>

                        </div> -->

                        <div class="col-12 <?= $facture_graph ?>">

                            <div class="chart-title">

                                Nombre Facture

                            </div>

                            <div id="graph_facture"></div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

        <script>           

            ////////////////////// GRAPH FACTURE ////////////////////////////////

            var graph_facture = new ApexCharts(document.querySelector("#graph_facture"), {

                chart: {
                    type: "bar",
                    height: 500
                },

                series: [{
                        name: "Semaine 1",
                        data: <?= json_encode($datafacture1) ?>
                    },
                    {
                        name: "Semaine 2",
                        data: <?= json_encode($datafacture2) ?>
                    }
                ],

                xaxis: {
                    categories: [
                        "Lundi",
                        "Mardi",
                        "Mercredi",
                        "Jeudi",
                        "Vendredi",
                        "Samedi",
                        "Dimanche"
                    ]
                },

                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "50%"
                    }
                },

                dataLabels: {
                    enabled: false
                },

                legend: {
                    position: "top"
                }

            });
            graph_facture.render();

            //////////////////////// GRAPH BATCH JOURNALIER JOUR //////////////////////////////

            var timeline = new ApexCharts(document.querySelector("#timeline"), {

                chart: {
                    type: "rangeBar",
                    height: 420
                },

                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 4
                    }
                },

                xaxis: {
                    type: "datetime"
                },

                series: [{

                    data: <?= $DayData ?>
                    /*[

                        {
                            x: "LECC0510",
                            y: [
                                new Date("2026-07-15 08:00").getTime(),
                                new Date("2026-07-15 08:12").getTime()
                            ]
                        },

                        {
                            x: "CALC_CSMO",
                            y: [
                                new Date("2026-07-15 08:12").getTime(),
                                new Date("2026-07-15 08:18").getTime()
                            ]
                        },

                        {
                            x: "ESTIMATION",
                            y: [
                                new Date("2026-07-15 08:18").getTime(),
                                new Date("2026-07-15 08:28").getTime()
                            ]
                        },

                        {
                            x: "FACC000",
                            y: [
                                new Date("2026-07-15 08:28").getTime(),
                                new Date("2026-07-15 08:31").getTime()
                            ]
                        },

                        {
                            x: "CB_SPLIT",
                            y: [
                                new Date("2026-07-15 08:31").getTime(),
                                new Date("2026-07-15 08:42").getTime()
                            ]
                        }

                    ]*/

                }]

            });
            timeline.render();            

            var donut = new ApexCharts(document.querySelector("#donut"), {

                chart: {
                    type: "donut",
                    height: 350
                },

                series: [
                    12,
                    6,
                    10,
                    3,
                    11
                ],

                labels: [
                    "LECC0510",
                    "CALC_CSMO",
                    "ESTIMATION",
                    "FACC000",
                    "CB_SPLIT"
                ]

            });
            donut.render();

            /////////////////////// GRAPH VITESSE BATCH PAR JOUR ///////////////////////////////

            // var duration = new ApexCharts(document.querySelector("#duration"), {

            //     chart: {
            //         type: "line",
            //         height: 500
            //     },

            //     series: [{
            //         name: "Durée",
            //         data: 
            //     }],

            //     xaxis: {
            //         categories: 
            //     },

            //     yaxis: {
            //         tickAmount: 10,
            //         labels: {
            //             formatter: function(value) {
            //                 return value.toFixed(2);
            //             }
            //         }
            //     },

            //     stroke: {
            //         curve: "smooth",
            //         width: 3
            //     },

            //     markers: {
            //         size: 5
            //     },

            //     dataLabels: {
            //         enabled: true
            //     }

            // });
            // duration.render();

            var chart = new ApexCharts(document.querySelector("#duration"), {

                chart: {
                    height: 500,
                    type: "line"
                },

                series: [

                    {
                        name: "Vitesse",
                        type: "line",
                        data: <?= sizeof($BatchDayData) > 0 ?  json_encode($BatchDayData[1]) : "[]" ?>
                    },

                    {
                        name: "Traités",
                        type: "column",
                        data: <?= sizeof($BatchDayData) > 0 ? json_encode($BatchDayData[2]) : "[]" ?>
                    }

                ],

                xaxis: {
                    categories: <?= sizeof($BatchDayData) > 0 ? json_encode($BatchDayData[3]) : "[]" ?>
                },

                yaxis: [

                    {
                        title: {
                            text: "Vitesse (Enregistrement/s)"
                        },
                        labels: {
                            formatter: function(val) {
                                return Number(val).toFixed(2);
                            }
                        }
                    },

                    {
                        opposite: true,

                        title: {
                            text: "Enregistrements"
                        },

                        labels: {
                            formatter: function(val) {
                                return val.toLocaleString();
                            }
                        }
                    }

                ],

                stroke: {
                    width: [3, 0],
                    curve: "smooth"
                },

                plotOptions: {
                    bar: {
                        columnWidth: "45%"
                    }
                },

                dataLabels: {
                    enabled: true
                },

                markers: {
                    size: 5
                },

                tooltip: {
                    shared: true,
                    intersect: false
                }

            });
            chart.render();

            //////////////////////////////////////////////////////

            // var records = new ApexCharts(document.querySelector("#records"), {

            //     chart: {
            //         type: "bar",
            //         height: 320
            //     },

            //     series: [{

            //         name: "Lignes",

            //         data: [
            //             1250000,
            //             420000,
            //             860000,
            //             120000,
            //             1950000
            //         ]

            //     }],

            //     xaxis: {

            //         categories: [
            //             "LECC0510",
            //             "CALC_CSMO",
            //             "ESTIMATION",
            //             "FACC000",
            //             "CB_SPLIT"
            //         ]

            //     }

            // });
            // records.render();

        </script>

    </section>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('template/layout.php') ?>