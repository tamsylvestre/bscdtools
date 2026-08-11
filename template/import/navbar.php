<!-- Preloader -->
<!-- <div class="preloader flex-column justify-content-center align-items-center">
  <img class=".animation_shake" src="template/dist/img/Eneo_logo.jpg" alt="Logo" />
</div> -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL."/dashboard" ?>" role="button"><i class="fas fa-home"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= BASE_URL."/dashboard" ?>" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link active" role="button">
                <i> <?= $_SESSION['user']->username ?> </i>
            </a>
        </li>

        <li class="nav-item invisible">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-cog"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL."/access/logout" ?>" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>

    </ul>
</nav>