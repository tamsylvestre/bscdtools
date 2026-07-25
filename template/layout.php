<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> BSCD TOOLS </title>
    <link rel="icon" href="<?= BASE_URL ?>/template/dist/img/eneo_logo.jpg" sizes="32x32">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/fontawesome-free/css/all.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/daterangepicker/daterangepicker.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/ekko-lightbox/ekko-lightbox.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?= BASE_URL ?>/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/jqvmap/jqvmap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/dist/css/adminlte.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/dist/css/custom.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/daterangepicker/daterangepicker.css"> -->
    <!-- summernote -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/summernote/summernote-bs4.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?= BASE_URL ?>/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        :root {
            --bg: #0a0e14;
            --surface: #0f1520;
            --border: #1e2d42;
            --accent: #00e5a0;
            --accent2: #0084ff;
            --warn: #ffb800;
            --error: #ff4566;
            --text: #c8d8f0;
            --text-dim: #4a6080;
            --mono: 'JetBrains Mono', monospace;
            --sans: 'Syne', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Terminal */
        .terminal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 60px rgba(0, 229, 160, 0.04), 0 24px 48px rgba(0, 0, 0, 0.5);
            position: sticky;
            top: 10px;
            z-index: 100;
        }

        .terminal-bar {
            background: #111925;
            border-bottom: 1px solid var(--border);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dots {
            display: flex;
            gap: 6px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dot.r {
            background: #ff5f57;
        }

        .dot.y {
            background: #febc2e;
        }

        .dot.g {
            background: #28c840;
        }

        .server-label {
            margin-left: auto;
            font-size: 11px;
            color: var(--text-dim);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--text-dim);
            transition: background 0.3s;
        }

        #status-dot.running {
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
            animation: pulse 1s infinite;
        }

        #status-dot.done {
            background: var(--accent2);
        }

        #status-dot.error {
            background: var(--error);
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        .terminal-output {
            padding: 20px;
            min-height: 420px;
            max-height: 60vh;
            overflow-y: auto;
            font-size: 13px;
            line-height: 1.7;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }

        .terminal-output::-webkit-scrollbar {
            width: 4px;
        }

        .terminal-output::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        .line {
            display: flex;
            gap: 12px;
            animation: fadein 0.15s ease;
        }

        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(2px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .ts {
            color: var(--text-dim);
            font-size: 11px;
            flex-shrink: 0;
            margin-top: 2px;
            user-select: none;
        }

        .line-text {
            word-break: break-all;
        }

        .line.info .line-text {
            color: var(--accent2);
        }

        .line.warn .line-text {
            color: var(--warn);
        }

        .line.error .line-text {
            color: var(--error);
        }

        .line.log .line-text {
            color: var(--text);
        }

        .line.done .line-text {
            color: var(--accent);
            font-weight: 700;
        }

        .prompt {
            color: var(--accent);
            user-select: none;
            flex-shrink: 0;
        }

        /* Barre inférieure */
        .controls {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        button {
            font-family: var(--mono);
            font-size: 13px;
            padding: 10px 24px;
            border-radius: 8px;
            border: 1px solid;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        #btn-run {
            background: var(--accent);
            color: #000;
            border-color: var(--accent);
        }

        #btn-run:hover:not(:disabled) {
            background: #00ffb3;
            box-shadow: 0 0 20px rgba(0, 229, 160, 0.35);
        }

        #btn-run:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        #btn-clear {
            background: transparent;
            color: var(--text-dim);
            border-color: var(--border);
        }

        #btn-clear:hover {
            color: var(--text);
            border-color: var(--text-dim);
        }

        #status-text {
            margin-left: auto;
            font-size: 12px;
            color: var(--text-dim);
        }

        .cursor0 {
            display: inline-block;
            width: 8px;
            height: 14px;
            background: var(--accent);
            animation: blink 1s step-end infinite;
            vertical-align: middle;
            margin-left: 2px;
            border-radius: 1px;
        }
        @keyframes blink { 50% { opacity: 0; } }
    </style>
    
    <!-- ApexCharts script -->
    <script src="<?= BASE_URL ?>/template/plugins/apexcharts/apexcharts.js"></script>
</head>

<body class="hold-transition layout-top-nav">
    <!-- <div class="overlay" id="loading" role="status" aria-live="polite" aria-label="Chargement en cours">
        <div class="loader" aria-hidden="true"></div>
    </div> -->

    <!-- pop up AD -->
    <div id="overlayAD">
        <div id="popup">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-default" id="closePopup">
                                <i class="fas fa-times fa-1x"></i>
                            </button>
                        </div>

                        <div class="form-group col-12">
                            <label for="assignto"> <code> Cherchez : </code> </label>
                            <div class="input-group mb-3">
                                <input type="text" id="searchtxtAD" class="form-control">
                                <div class="input-group-append pointer">
                                    <span class="input-group-text" id="searchAD"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="loader" style="display: none;"></div>

                        <div class="col-12 mt-1">
                            <label for="assignto"> <code> Selectionnez un utilisateur : </code> </label>
                            <div class="form-group">
                                <select multiple class="custom-select" id="selectAD">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button class="btn btn-outline-info btn-sm btnValidAD"> <i class="fas fa-check"></i> VALIDER
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="wrapper">

        <?php require('template/import/navbar.php'); ?>
        <?= $content ?>

    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <h5 class="text-center">Administration</h5>
        <hr class="mb-2" />
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/administration/users" class="nav-link btn_nav_link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Utilisateurs
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </aside>

    <script>
        let BASE_URL = "<?= BASE_URL ?>";
    </script>

    <!-- function js -->
    <script src="<?= BASE_URL ?>/template/dist/js/function.js"></script>
    <!-- jQuery -->
    <script src="<?= BASE_URL ?>/template/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= BASE_URL ?>/template/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= BASE_URL ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="<?= BASE_URL ?>/template/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- Filterizr-->
    <script src="<?= BASE_URL ?>/template/plugins/filterizr/jquery.filterizr.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="<?= BASE_URL ?>/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <!-- InputMask -->
    <script src="<?= BASE_URL ?>/template/plugins/moment/moment.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= BASE_URL ?>/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?= BASE_URL ?>/template/plugins/select2/js/select2.full.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= BASE_URL ?>/template/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- AdminLTE App -->
    <script src="<?= BASE_URL ?>/template/dist/js/adminlte.js"></script>
    <!-- ChartJS -->
    <script src="<?= BASE_URL ?>/template/plugins/chart.js/Chart.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?= BASE_URL ?>/template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/jszip/jszip.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= BASE_URL ?>/template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "sort": false,
                "buttons": ["copy", "csv", "excel"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        //Date picker
        // $('#reservationdate').datetimepicker({
        //     format: 'L'
        // });

        //Date range picker
        $('#reservation').daterangepicker({

            locale: {
                format: 'YYYY-MM-DD',
                separator: ' | '
            }

        });

        $('.reservation').daterangepicker({

            locale: {
                format: 'YYYY-MM-DD',
                separator: ' | '
            }

        });

        //Date and time picker
        // $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
    </script>

    <!-- custum js -->
    <script src="<?= BASE_URL ?>/template/dist/js/custom.js"></script>
</body>

</html>