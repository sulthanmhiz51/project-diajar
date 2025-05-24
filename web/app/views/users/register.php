<?php
$role = $_GET['role'] ?? 0;

if ($role == 0 && !isset($_GET['error'])) :
?>

    <!-- Role Choosing Modal -->
    <div class="modal fade align-middle" id="roleSelectionModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Register New Account</h1>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <a href="<?= BASEURL ?>/users/register?role=1" class="btn btn-primary d-block my-3">Register as
                            Student</a>
                        <a href="<?= BASEURL ?>/users/register?role=2" class="btn btn-primary d-block my-3">Register as
                            Instructor</a>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class=>Already have an account? <a href="<?= BASEURL ?>/users/auth">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#roleSelectionModal").modal("show");
        });
    </script>

<?php else : $_SESSION['role'] = $role;
endif ?>

<div class="container">
    <div class="col">
        <?php Flasher::flash() ?>
    </div>
</div>

<!-- Main Register Interface -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto order-2">
            <div class="container bg-primary mt-4 p-4 px-5 p-md-5 rounded-top-4">
                <h2 class="text-light" id="registerLabel">Register New Account</h2>
            </div>
            <div class="container bg-body-secondary p-5 rounded-bottom-4">
                <div class="register-body">
                    <form action="<?= BASEURL ?>/users/submitRegistration" method="POST">
                        <input type="hidden" name="role" value="<?= $_SESSION['role'] ?? 0 ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input required type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input required type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input required type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password2" class="form-label">Confirm Password</label>
                            <p id="password-match" class="text-danger d-none">Password didn't match</p>
                            <input required type="password" class="form-control" id="password2">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-none d-md-block"></div>
    <div class="col order-1 d-none d-md-block">
        <h1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda in sequi alias ea neque cumque
            architecto doloribus quis ex cum.</h1>
    </div>
</div>
</div>

<p><?php var_dump($_POST) ?></p>

<script>
    $(function() {
        $('#password, #password2').on('keyup', function() {
            var pw = $('#password').val();
            var pw2 = $('#password2').val();
            if (pw !== pw2) $('#password-match').removeClass('d-none');
            else $('#password-match').addClass('d-none');
        })
    })
</script>