<?php
if (isset($_SESSION['user'])) {
    header("Location: ../");
}
?>

<div class="container">
    <div class="col">
        <?php Flasher::flash() ?>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-9 col-lg-4 order-2">
            <div class="container bg-primary mt-4 p-3 px-4 rounded-top-4">
                <h2 class="text-light" id="registerLabel">Sign In </h2>
            </div>
            <div class="container bg-body-secondary p-4">
                <div class="body">
                    <form action="<?= BASEURL ?>/users/signIn" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input required type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input required type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container d-flex bg-body-secondary p-2 pt-3 rounded-bottom-4 border-top justify-content-center">
                <p>Don't have account? <a href="<?= BASEURL ?>/users/register">Register</a></p>
            </div>
        </div>
        <div class="w-100 d-none d-md-block"></div>
        <div class="col order-1 d-none d-lg-block">
            <h1>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sapiente dolores obcaecati nemo quis
                blanditiis provident quos beatae culpa magnam iure?</h1>
        </div>
    </div>
</div>