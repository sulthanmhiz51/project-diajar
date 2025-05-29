<?php

class Users extends Controller
{
    protected $middleware = [
        ['GuestsMiddleware', ['auth', 'register']],
        ['AuthMiddleware', ['profile']]
    ];
    public function index()
    {
        // $data['judul'] = 'Register';
        // $this->view('templates/header', $data);
        // $this->view('users/register');
        // $this->view('templates/footer');
    }
    public function auth()
    {
        $data['judul'] = 'Sign In';
        $this->view('templates/header', $data);
        $this->view('users/auth');
        $this->view('templates/footer');
    }
    public function signIn()
    {
        $signIn = $this->model('Users_model')->signIn($_POST);
        if ($signIn['success'] == true) {
            header('Location: ' . BASEURL . '/');
            exit;
        } else {
            Flasher::setFlash($signIn['error_msg'],  "danger");
            header('Location: ' . BASEURL . '/users/auth?error=' . $signIn['error']);
            exit;
        }
    }
    public function signOut()
    {
        session_destroy();
        session_unset();
        header('Location: ' . BASEURL);
    }
    public function register()
    {
        $data['judul'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('users/register');
        $this->view('templates/footer');
    }
    public function submitRegistration()
    {
        $registration = $this->model('Users_model')->registerAccount($_POST);
        if ($registration['success'] == true) {
            Flasher::setFlash('Your account has been successfully registered. <br> You may sign in to your account.', 'success');
            header('Location: ' . BASEURL . '/users/auth');
            exit;
        } else {
            Flasher::setFlash($registration['error_msg'],  "danger");
            header('Location: ' . BASEURL . '/users/register?error=' . $registration['error'] . '&role=' . $registration['role']);
            exit;
        }
    }
    public function profile()
    {
        $data['judul'] = 'My Profile';
        $this->view('templates/header', $data);
        $this->view('users/profile');
        $this->view('templates/footer');
    }

    public function getProfileDataAjax()
    {
        // Set content type to JSON
        header('Content-Type: application/json');

        // Ensure user is logged in
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }

        $profile = $this->model('Users_model')->getUserProfileById($userId);

        if ($profile) {
            // Add full path to profile picture for display in front-end
            // Ensure 'no-profile.png' is your default image in the 'img/' directory
            $profile['profilePictureURL'] = BASEURL . '/img/profile/' . ($profile['photo_url'] ?? 'no-profile.png');
            echo json_encode(['success' => true, 'data' => $profile]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Profile data not found for user ID: ' . $userId]);
        }
        exit;
    }

    /**
     * Handles AJAX POST request for updating user profile.
     * Returns JSON response
     */
    public function updateProfile()
    {
        // Set content type to JSON
        header('Content-Type: application/json');

        // Basic validation for POST and AJAX request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method or not an AJAX request.']);
            exit;
        }

        // Ensure user ID is available from session
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }

        // Prepare data for the model from $_POST
        $profileData = [
            'firstName' => $_POST['firstName'] ?? '',
            'lastName' => $_POST['lastName'] ?? '',
            'birthdate' => $_POST['birthdate'] ?? '',
            'phoneNum' => $_POST['phoneNum'] ?? '',
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'currentPassword' => $_POST['currentPassword'] ?? '',
            'newPassword' => $_POST['newPassword'] ?? ''
        ];

        // Pass the $_FILES['profilePicture'] array directly to the model
        $profilePictureFile = $_FILES['profilePicture'] ?? null;

        // Call the model to handle the update logic, including file upload
        $updateResult = $this->model('Users_model')->updateUserProfile(
            $userId,
            $profileData,
            $profilePictureFile
        );

        // Respond to the AJAX request based on the model's result
        if ($updateResult['success']) {
            // Re-fetch updated profile data to ensure all latest fields are sent back to the client
            $updatedProfile = $this->model('Users_model')->getUserProfileById($userId);

            // Construct the full URL for the profile picture if it was updated or remains the same
            $profilePhotoURL = BASEURL . '/img/profile/' . ($updatedProfile['photo_url'] ?? 'no-profile.png');
            if (!empty($updateResult['newPhotoFilename'])) {
                // If a new file was actually uploaded, use its name for the URL
                $profilePhotoURL = BASEURL . '/img/profile/' . $updateResult['newPhotoFilename'];
            }

            echo json_encode([
                'success' => true,
                'message' => $updateResult['message'],
                'updateResult' => $updateResult,
                'updatedData' => $updatedProfile, // Send back all updated data
                'profilePictureURL' => $profilePhotoURL // Send the new photo URL for display
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $updateResult['message']]);
        }
        exit;
    }
}