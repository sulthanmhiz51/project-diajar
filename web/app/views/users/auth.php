<div class="container-md d-flex justify-content-center allign-content-center h-100">
    <div class="bg-body-secondary w-lg-50 w-75 row flex-column justify-content-center px-xl-5 px-3 py-5">
        <div class="px-xl-5 py-5">
            <div class="form-header mb-3 py-2 border-bottom border-dark-subtle">
                <h3 id="signInLabel">Sign In </h3>
            </div>
            <div class="form-body">
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
            <div
                class="form-footer d-flex bg-body-secondary p-2 pt-3 rounded-bottom-4 border-top justify-content-center">
                <p>Don't have account? <a href="<?= BASEURL ?>/users/register">Register</a></p>
            </div>
        </div>
    </div>
</div>