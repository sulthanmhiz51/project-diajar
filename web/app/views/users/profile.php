<div class="profile d-flex justify-content-center allign-content-center h-100">
    <div class="bg-body-secondary w-75">
        <div class="container mt-3">
            <div class="container">
                <form class="row row-cols-1" id="profileForm" action="<?= BASEURL ?>/users/updateProfile" method="post"
                    enctype="multipart/form-data">
                    <div class="container mt-5 d-flex justify-content-between">
                        <h2>My Profile</h2>
                        <button class="btn btn-sm btn-outline-danger my-auto"> Delete Account</button>
                    </div>
                    <hr>
                    <div class="col my-4">
                        <div class="row justify-content-between py-2">
                            <div class=" col-6 d-flex">
                                <div class="col-4 d-flex flex-column justify-content-center">
                                    <img id="profilePictureDisplay" src="<?= BASEURL ?>/img/no-profile.png"
                                        class="rounded-circle border border-primary mb-1 mx-auto"
                                        style="width: 150px; height: 150px; object-fit: cover;" alt="Profile Avatar" />
                                    <input class="form-control form-control-sm d-none" id="profilePictureInput"
                                        name="profilePicture" type="file">
                                </div>
                                <div class="container align-self-center text-start">
                                    <h5 id="profileName" class="mb-2">John Doe</h5>
                                    <p id="profileEmail" class="text-muted">johndoe24002@mail.unpad.ac.id </p>
                                </div>
                            </div>
                            <div class="col-auto d-flex">
                                <div class="container align-self-center text-start">
                                    <button type="button" id="editProfileBtn"
                                        class="btn btn-primary me-2 shadow-sm">Edit Profile</button>
                                    <button type="button" id="discardChangesBtn"
                                        class="d-none btn btn-secondary me-2 shadow-sm">Discard Changes</button>
                                    <button type="submit" id="saveProfileBtn"
                                        class="btn btn-primary d-none shadow-sm">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <fieldset id="profileFormFields" disabled>
                            <div class="row row-cols-2 text-start g-3">
                                <div class="col">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" id="firstName" name="firstName" class="form-control "
                                        placeholder="" aria-label="First name">
                                </div>
                                <div class="col">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" class="form-control "
                                        placeholder="" aria-label="Last name">
                                </div>
                                <div class="col">
                                    <label for="birthdate" class="form-label">Birthdate</label>
                                    <input type="date" id="birthdate" name="birthdate" class="form-control "
                                        placeholder="" aria-label="Birthdate">
                                </div>
                                <div class="col">
                                    <label for="phoneNum" class="form-label">Phone number</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">(+62)</span>
                                        <input type="text" id="phoneNum" name="phoneNum" class="form-control "
                                            placeholder="" aria-label="Phone number">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="Enter username" aria-label="Username">
                                </div>
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter email" aria-label="Email">
                                </div>
                                <div class="col-12 mt-4">
                                    <h5 class="mb-3">Change Password (Optional)</h5>
                                </div>
                                <div class="col">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" id="currentPassword" name="currentPassword"
                                        class="form-control">
                                </div>
                                <div class="col">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" id="newPassword" name="newPassword" class="form-control">
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" id="confirmNewPassword" name="confirmNewPassword"
                                        class="form-control">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        const profileForm = $('#profileForm');
        const profileFormFields = $('#profileFormFields');
        const editProfileBtn = $('#editProfileBtn');
        const discardChangesBtn = $('#discardChangesBtn');
        const saveProfileBtn = $('#saveProfileBtn');
        const profilePictureInput = $('#profilePictureInput');
        const profilePictureDisplay = $('#profilePictureDisplay');
        const profileName = $('#profileName');
        const profileEmail = $('#profileEmail');

        function isImageURLValid(url, callback) {
            const img = new Image();
            img.onload = function() {
                callback(true);
            };
            img.onerror = function() {
                callback(false);
            };
            img.src = url;
        }

        function loadProfileData() {
            $.ajax({
                url: window.APP_CONFIG.BASEURL + '/users/getProfileDataAjax',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Populate header info
                        profileName.text(data.first_name + ' ' + data.last_name);
                        profileEmail.text(data.email);
                        isImageURLValid(data.profilePictureURL, function(isValid) {
                            if (isValid) {
                                profilePictureDisplay.attr('src', data.profilePictureURL);
                            } else {
                                profilePictureDisplay.attr('src', window.APP_CONFIG.BASEURL +
                                    '/img/no-profile.png'); // fallback image
                            }
                        });

                        // Populate form fields
                        $('#firstName').val(data.first_name);
                        $('#lastName').val(data.last_name);
                        $('#birthdate').val(data.birthdate);
                        $('#phoneNum').val(data.phone_num);
                        $('#username').val(data.username);
                        $('#email').val(data.email);

                        //Clear password fields on load
                        $('#currentPassword').val('');
                        $('#newPassword').val('');
                        $('#confirmNewPassword').val('');
                    } else {
                        // Use SweetAlert2 for better user experience
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error!', response.message, 'error');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('AJAX Error!', 'Could not load profile data: ' + error, 'error');
                    } else {
                        alert('AJAX Error: Could not load profile data.');
                    }
                }
            });
        }

        // Initial load of profile data when the page is ready
        loadProfileData();

        // Event listener for Edit button
        editProfileBtn.on('click', function() {
            profileFormFields.prop('disabled', false);
            profilePictureInput.removeClass('d-none');
            discardChangesBtn.removeClass('d-none');
            saveProfileBtn.removeClass('d-none');
            editProfileBtn.addClass('d-none');
        })

        // Event listener for Discard Changes button
        discardChangesBtn.on('click', function() {
            Swal.fire({
                title: "Discard changes you made?",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {

                    profileFormFields.prop('disabled', true);
                    profilePictureInput.addClass('d-none');
                    discardChangesBtn.addClass('d-none');
                    saveProfileBtn.addClass('d-none');
                    editProfileBtn.removeClass('d-none');
                    loadProfileData();

                }
            });

        })

        // Event listener for form submission (Save button)
        profileForm.on('submit', function(e) {
            e.preventDefault(); // Prevent default formm submission

            // Basic client-side password validation
            const newPassword = $('#newPassword').val();
            const confirmNewPassword = $('#confirmNewPassword').val();
            const currentPassword = $('#currentPassword').val();

            if (newPassword !== '' || currentPassword !== '') { // If user is attempting to change password
                if (newPassword === '') {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'New password cannot be empty if changing password.',
                            'warning');
                    } else {
                        alert('New password cannot be empty if changing password.');
                    }
                    return;
                }
                if (newPassword !== confirmNewPassword) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'New password and confirmation do not match.',
                            'warning');
                    } else {
                        alert('New password and confirmation do not match.');
                    }
                    return;
                }
                if (currentPassword === '') {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'Current password is required to change password.',
                            'warning');
                    } else {
                        alert('Current password is required to change password.');
                    }
                    return;
                }
            }

            // Create FormData object to send both text and file data
            const formData = new FormData(this);

            $.ajax({
                url: profileForm.attr('action'),
                method: 'POST',
                data: formData,
                processData: false, // Important: Don't process the data
                contentType: false, // Important: Don't set content type (FormData does it)
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Success!', response.message, 'success');
                        } else {
                            alert('Success: ' + response.message);
                        }

                        // Update displayed info with new data from response
                        profileName.text(response.updatedData.first_name + ' ' + response
                            .updatedData.last_name);
                        profileEmail.text(response.updatedData.email);
                        isImageURLValid(response.profilePictureURL, function(isValid) {
                            if (isValid) {
                                profilePictureDisplay.attr('src', response
                                    .profilePictureURL);
                            } else {
                                profilePictureDisplay.attr('src', window.APP_CONFIG
                                    .BASEURL +
                                    '/img/no-profile.png'); // fallback image
                            }
                        });

                        // Re-disable form fields and hide/show buttons
                        profileFormFields.prop('disabled', true);
                        profilePictureInput.addClass('d-none');
                        discardChangesBtn.addClass('d-none');
                        saveProfileBtn.addClass('d-none');
                        editProfileBtn.removeClass('d-none');

                        // Clear password fields after successful update
                        $('#currentPassword').val('');
                        $('#newPassword').val('');
                        $('#confirmNewPassword').val('');
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error!', response.message, 'error');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('AJAX Error!', 'Could not update profile: ' + error, 'error');
                    } else {
                        alert('AJAX Error: Could not update profile.');
                    }
                }
            });
        });
    });
</script>