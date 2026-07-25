<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EXTRACTOR</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/template/dist/css/adminlte.min.css">
</head>

<body class=" pt-5">
    <div class="error-page  pt-5">

        <h2 class="headline text-warning">
            <i class="fas fa-exclamation-triangle text-warning"></i>
        </h2>

        <div class="error-content">
            <h2> Oops! </h2>
            <h3> <?=$error?>.</h3>

            <h3  class="lead">
                Vous pouvez <a href="<?= BASE_URL ?>"> retourner à la page d'acceuil </a> ou contacter
                l'administrateur.
            </h3>
        </div>
    </div>
    <!-- /.error-content -->

</body>

</html>>