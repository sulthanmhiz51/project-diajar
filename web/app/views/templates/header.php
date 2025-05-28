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

    <!-- Navbar -->
    <?php if (!isset($_SESSION['username'])) : ?>

        <!-- User is not signed in -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container px-3">
                <a class="navbar-brand" href="<?= BASEURL ?>">PHP MVC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="<?= BASEURL ?>">Home</a>
                        <a class="nav-link" href="<?= BASEURL ?>/mahasiswa">Mahasiswa</a>
                        <a class="nav-link" href="<?= BASEURL ?>/about">About</a>
                    </div>
                    <a href="<?= BASEURL ?>/users/auth" class="btn btn-outline-primary col-auto">Sign In</a>
                </div>
            </div>
        </nav>

    <?php else : ?>
        <!-- User is signed in -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container px-3">
                <a class="navbar-brand" href="<?= BASEURL ?>">PHP MVC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="<?= BASEURL ?>">Home</a>
                        <a class="nav-link" href="<?= BASEURL ?>/mahasiswa">Mahasiswa</a>
                        <a class="nav-link" href="<?= BASEURL ?>/about">About</a>
                    </div>
                    <a href="<?= BASEURL ?>/users/signOut" class="btn btn-outline-danger col-auto">Sign Out</a>
                </div>
            </div>
        </nav>
    <?php endif ?>

    <div class="container">
        <div class="col">
            <?php Flasher::flash() ?>
        </div>
    </div>



    <!-- 
    sign in modal

    <div class="modal fade" id="signInModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div> -->