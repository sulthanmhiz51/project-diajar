<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?></title>
    <link rel="stylesheet" href="<?= BASEURL ?>/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/override.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Declare a global variable with the value from your environment
    window.APP_CONFIG = {
        BASEURL: "<?= BASEURL ?>"
    };
    </script>

</head>

<body>
    <div class="d-flex flex-column vh-100 overflow-hidden"
        style="background-image: url(<?= BASEURL ?>/img/css-pattern-by-magicpattern.png);">

        <!-- Navbar -->
        <?php if (!isset($_SESSION['username'])) : ?>

        <!-- User is not signed in -->
        <nav class="navbar navbar-expand-lg bg-body border-bottom">
            <div class="container px-3">
                <a class="navbar-brand" href="<?= BASEURL ?>">Diajar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="<?= BASEURL ?>">Home</a>
                        <a class="nav-link" href="<?= BASEURL ?>/mahasiswa">Mahasiswa</a>
                        <a class="nav-link" href="<?= BASEURL ?>/users/profile">Profile</a>
                    </div>
                    <a href="<?= BASEURL ?>/users/auth" class="btn btn-outline-primary col-auto">Sign In</a>
                </div>
            </div>
        </nav>

        <?php else : ?>
        <!-- User is signed in -->
        <nav class="navbar navbar-expand-lg border-bottom">
            <div class="container px-3">
                <a class="navbar-brand" href="<?= BASEURL ?>">Diajar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="<?= BASEURL ?>">Home</a>
                        <a class="nav-link" href="<?= BASEURL ?>/mahasiswa">Mahasiswa</a>
                        <a class="nav-link" href="<?= BASEURL ?>/users/profile">Profile</a>
                    </div>
                    <a href="<?= BASEURL ?>/users/signOut" class="btn btn-outline-danger col-auto">Sign Out</a>
                </div>
            </div>
        </nav>
        <?php endif ?>

        <div class="col position-relative">

            <div class="container-md position-absolute top-0 start-50 translate-middle-x">
                <div class="col">
                    <?php Flasher::flash() ?>
                </div>
            </div>