<html>

<head>
    <link rel="icon" href="<?= BASE_URL ?>/template/dist/img/eneo_logo.jpg" sizes="32x32">
    <title> Portal </title>
    <!-- CORE CSS-->
    <link href="<?= BASE_URL ?>/template/dist/css/materialize.css" type="text/css" rel="stylesheet">
    <style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
    }

    body {
        background: #fff;
    }

    .input-field input[type=date]:focus+label,
    .input-field input[type=text]:focus+label,
    .input-field input[type=email]:focus+label,
    .input-field input[type=password]:focus+label {
        color: #e91e63;
    }

    .input-field input[type=date]:focus,
    .input-field input[type=text]:focus,
    .input-field input[type=email]:focus,
    .input-field input[type=password]:focus {
        border-bottom: 2px solid #e91e63;
        box-shadow: none;
    }
    </style>
</head>

<body>
    <div class="section"></div>
    <main>
        <center>
            <img class="responsive-img" style="width: 250px;" src="<?= BASE_URL ?>/template/dist/img/eneo_logo.jpg" />
            <div class="section"></div>

            <h5 class="indigo-text">Please, login with your camlight account </h5>
            <div class="section"></div>
            <h5 class="red-text"> <?= (isset($error)) ? $error : "" ?> </h5>
            <div class="container">
                <div class="z-depth-1 grey lighten-4 row"
                    style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

                    <form class="col s12" method="post" action="<?= BASE_URL ?>/access">
                        <div class='row'>
                            <div class='col s12'>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='input-field col s12'>
                                <input class='validate' type='text' name='userid' value=''
                                    placeholder='exple : "sylvestre.tam@camlight.cm"' required />
                                <label for='email'>Enter your Login :</label>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='input-field col s12'>
                                <input class='validate' type='password' name='password' value='' required />
                                <label for='password'>Enter your password</label>
                            </div>
                            <label style='float: right;'>
                                <a class='pink-text' href=''><b>Forgot Password?</b></a>
                            </label>
                        </div>

                        <br />
                        <center>
                            <div class='row'>
                                <button type='submit' class='col s12 btn btn-large waves-effect indigo'>
                                    Login
                                </button>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </center>

        <div class="section"></div>
        <div class="section"></div>
    </main>

    <!-- jQuery Library -->
    <script type="text/javascript" src="<?= BASE_URL ?>/template/plugins/jquery/jquery.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="<?= BASE_URL ?>/template/dist/js/materialize.min.js"></script>
</body>

</html>