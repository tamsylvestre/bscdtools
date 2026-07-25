<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>Dashboard Batch</title>

    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <script src="<?= BASE_URL ?>/template/plugins/apexcharts/apexcharts.js"></script>

    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: Segoe UI, Arial;
        }

        .container {

            width: 95%;
            margin: auto;
            margin-top: 20px;

        }

        .title {

            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;

        }

        .cards {

            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;

        }

        .card {

            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);

        }

        .card h2 {

            margin: 0;
            color: #1976D2;
            font-size: 34px;

        }

        .card span {

            color: #666;

        }

        .row {

            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-top: 20px;

        }

        .panel {

            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            padding: 15px;

        }

        .chart-title {

            font-weight: bold;
            margin-bottom: 10px;

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="title">

            Batch LECC0510

        </div>

        <div class="cards">

            <div class="card">

                <h2>42 min</h2>

                <span>Durée Totale</span>

            </div>

            <div class="card">

                <h2>12</h2>

                <span>Scripts exécutés</span>

            </div>

            <div class="card">

                <h2>5 426 812</h2>

                <span>Données traitées</span>

            </div>

            <div class="card">

                <h2 style="color:green">SUCCESS</h2>

                <span>Statut</span>

            </div>

        </div>

        <div class="row">

            <div class="panel">

                <div class="chart-title">

                    Chronologie des scripts

                </div>

                <div id="timeline"></div>

            </div>

            <div class="panel">

                <div class="chart-title">

                    Répartition du temps

                </div>

                <div id="donut"></div>

            </div>

        </div>

        <div class="row">

            <div class="panel">

                <div class="chart-title">

                    Temps d'exécution (secondes)

                </div>

                <div id="duration"></div>

            </div>

            <div class="panel">

                <div class="chart-title">

                    Enregistrements traités

                </div>

                <div id="records"></div>

            </div>

        </div>

    </div>

    <script>
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

                data: [

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

                ]

            }]

        });

        timeline.render();

        //////////////////////////////////////////////////////

        var duration = new ApexCharts(document.querySelector("#duration"), {

            chart: {
                type: "bar",
                height: 320
            },

            series: [{

                name: "Durée",

                data: [720, 360, 600, 180, 660]

            }],

            xaxis: {

                categories: [
                    "LECC0510",
                    "CALC_CSMO",
                    "ESTIMATION",
                    "FACC000",
                    "CB_SPLIT"
                ]

            }

        });

        duration.render();

        //////////////////////////////////////////////////////

        var records = new ApexCharts(document.querySelector("#records"), {

            chart: {
                type: "bar",
                height: 320
            },

            series: [{

                name: "Lignes",

                data: [
                    1250000,
                    420000,
                    860000,
                    120000,
                    1950000
                ]

            }],

            xaxis: {

                categories: [
                    "LECC0510",
                    "CALC_CSMO",
                    "ESTIMATION",
                    "FACC000",
                    "CB_SPLIT"
                ]

            }

        });

        records.render();

        //////////////////////////////////////////////////////

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
    </script>

</body>

</html>