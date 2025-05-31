<?php

class Users_model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function registerAccount($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_ARGON2I);

        $query = "INSERT INTO " . $this->table . " (username, email, password, role_id)
                VALUES (:username, :email, :password, :role)";

        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('role', $data['role']);

        try {
            $this->db->execute();
            $userId = $this->db->lastInsertId(); // Get the newly created user's ID

            // Insert empty row into users_profile
            $profileQuery = "INSERT INTO users_profile
                            (user_id, first_name, last_name, birthdate, phone_num, photo_url)
                            VALUES (:user_id, '', '', NULL, '', NULL)";
            $this->db->query($profileQuery);
            $this->db->bind('user_id', $userId);
            $this->db->execute();
            return [
                'success' => true
            ];
        } catch (PDOException $e) {
            // Check for duplicate entry error (MySQL error code 1062)
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                // Custom message, you can also parse $e->getMessage() to decide which field is duplicate
                return [
                    'success' => false,
                    'error' => 1062,
                    'error_msg' => 'Username or email already registered.',
                    'role' => $data['role']
                ];
            }
            // For other errors, return a generic error (or log detailed info)
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'error_msg' => 'An unexpected error occurred.',
                'role' => $data['role']
            ];
        }
    }
    public function signIn($data)
    {
        $query = "SELECT u.*, r.name as role_name
                FROM " . $this->table . " u
                JOIN roles r ON u.role_id = r.id
                WHERE username = :username";

        $this->db->query($query);
        $this->db->bind('username', $data['username']);

        $user = $this->db->single();

        if ($user) {
            if (password_verify($data['password'], $user['password'])) {
                unset($user['password']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role_name'];
                return ['success' => true];
            } else {
                return [
                    'error' => 'password',
                    'error_msg' => 'You entered a wrog password',
                    'success' => false
                ];
            };
        } else {
            return [
                'error' => 'uname',
                'error_msg' => 'Username not found',
                'success' => false
            ];
        };
    }


    /**
     * Fetches a user's full profile details by user ID, joining users and user_profile tables.
     * @param int $userId The ID of the user.
     * @return array|false An associative array of user profile data, or false if not found.
     */

    public function getUserProfileById($userId)
    {
        $query = "SELECT u.id, u.username, u.email,
                up.first_name, up.last_name, up.birthdate, up.phone_num, up.photo_url
                FROM " . $this->table . " u
                JOIN users_profile up ON u.id = up.user_id
                WHERE u.id = :user_id";

        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        return $this->db->single();
    }

    /**
     * Updates or inserts a user's profile information, including handling file upload
     * @param int $userId The ID of the user.
     * @param array $profileData Associative array of profile fields
     * @param array|null $profilePictureFile Associative array from $_FILES['profilePicture'] if a file is uploaded, or null.
     * @return array An associative array with 'success', 'message', and 'newPhotoFilename' (string|null).
     */

    public function updateUserProfile($userId, array $profileData, ?array $profilePictureFile = null)
    {
        // Basic data sanitizer
        $firstName = htmlspecialchars($profileData['firstName'] ?? '');
        $lastName = htmlspecialchars($profileData['lastName'] ?? '');
        $birthdate = htmlspecialchars($profileData['birthdate'] ?? '');
        $phoneNum = htmlspecialchars($profileData['phoneNum'] ?? '');
        $username = htmlspecialchars($profileData['username'] ?? '');
        $email = htmlspecialchars($profileData['email'] ?? '');
        $currentPassword = $profileData['currentPassword'] ?? '';
        $newPassword = $profileData['newPassword'] ?? '';

        // Convert to correct format if needed
        $birthdate = date('Y-m-d', strtotime($birthdate)); // Output: 2025-05-29

        $newProfilePhotoName = null; // To store new uploaded photo name

        // --- Handle File Upload ---
        if ($profilePictureFile && $profilePictureFile['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../../public/img/profile/";
            $fileTmpPath = $profilePictureFile['tmp_name'];
            $fileName = $profilePictureFile['name'];
            $fileSize = $profilePictureFile['size'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            $newFileName = uniqid() . '_' . basename($fileName); // Generate unique name
            $destPath = $uploadDir . $newFileName;

            // Basic validation for file type and size
            $allowedFileExtensions = ['jpg', 'jpeg', 'png'];
            if (!in_array($fileExtension, $allowedFileExtensions)) {
                return [
                    'success' => false,
                    'message' => 'Only JPG, JPEG & PNG files are allowed'
                ];
            }
            if ($fileSize > 5000000) // Max 5MB
            {
                return [
                    'success' => false,
                    'message' => 'Profile picture is too big (max 5MB)'
                ];
            }
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                error_log("Failed to move uploaded file...");
                return ['success' => false, 'message' => 'Error uploading profile picture. Please try again.'];
            }

            // Fetch old photo filename
            $this->db->query("SELECT photo_url
                                    FROM users_profile
                                    WHERE user_id = :user_id");
            $this->db->bind('user_id', $userId);
            $currentPhoto = $this->db->single();

            $oldPhotoFile = $currentPhoto['photo_url'] ?? null;

            $newProfilePhotoName = $newFileName;
        }

        if ($newProfilePhotoName !== null && $oldPhotoFile && $oldPhotoFile !== 'no-profile.png') {
            $oldFilePath = __DIR__ . "/../../public/img/profile/" . $oldPhotoFile;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Delete old photo
            }
        }

        // --- Handle Password Change ---
        if (!empty($newPassword)) {
            // Fetch current password from DB to verify
            $this->db->query("SELECT password 
                            FROM " . $this->table . "
                            WHERE id = :user_id");
            $this->db->bind('user_id', $userId);
            $user = $this->db->single();

            if (!$user || !password_verify($currentPassword, $user['password'])) {
                return ['success' => false, 'message' => 'Current password is incorrect.'];
            }

            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_ARGON2I);

            // Update password in the users table
            $this->db->query("UPDATE " . $this->table . " 
                            SET password = :password 
                            WHERE id = :user_id");
            $this->db->bind('password', $hashedPassword);
            $this->db->bind('user_id', $userId);
            $this->db->execute();
            if ($this->db->rowCount() === 0) {
                return ['success' => false, 'message' => 'Failed to update password.'];
            }
        }
        // --- Update User Table (for username and email if applicable) ---
        try {
            $updateUserQuery = "UPDATE " . $this->table . "
                                    SET username = :username, email = :email 
                                    WHERE id = :user_id";
            $this->db->query($updateUserQuery);
            $this->db->bind('username', $username);
            $this->db->bind('email', $email);
            $this->db->bind('user_id', $userId);
            $this->db->execute();
            // We don't check rowCount for this update as it might be 0 if username/email didn't change
            // but the profile update should still proceed.

            // --- Update/Insert User Profile Table ---
            // Check if a profile entry exists for the user in the user_profile table
            $this->db->query("SELECT user_id 
                                    FROM users_profile 
                                    WHERE user_id = :user_id");
            $this->db->bind('user_id', $userId);
            $existingProfile = $this->db->single();

            if ($existingProfile) {
                // Update existing profile
                $query = "UPDATE users_profile
                            SET
                            first_name = :first_name,
                            last_name = :last_name,
                            birthdate = :birthdate,
                            phone_num = :phone_num";
                if ($newProfilePhotoName !== null) { // Only update photo_url if a new file was uploaded
                    $query .= ", photo_url = :photo_url";
                }
                $query .= " WHERE user_id = :user_id";

                $this->db->query($query);
            } else {
                // Insert new profile if it doesn't exist
                $query = "INSERT INTO users_profile
                            (user_id, first_name, last_name, birthdate, phone_num";
                if ($newProfilePhotoName !== null) { // Only include photo_url if a new file was uploaded
                    $query .= ", photo_url";
                }
                $query .= ") VALUES (:user_id, :first_name, :last_name, :birthdate, :phone_num";
                if ($newProfilePhotoName !== null) {
                    $query .= ", :photo_url";
                }
                $query .= ")";

                $this->db->query($query);
            }

            // Bind parameters common to both UPDATE and INSERT for user_profile
            $this->db->bind('user_id', $userId);
            $this->db->bind('first_name', $firstName);
            $this->db->bind('last_name', $lastName);
            $this->db->bind('birthdate', $birthdate);
            $this->db->bind('phone_num', $phoneNum);

            // Bind profile picture if provided
            if ($newProfilePhotoName !== null) {
                $this->db->bind('photo_url', $newProfilePhotoName);
            }

            $this->db->execute();

            // Return success with the new photo filename (if any)
            return ['success' => true, 'message' => 'Profile updated successfully!', 'new_photo_filename' => $newProfilePhotoName];
        } catch (PDOException $e) {
            error_log("Database Error in updateUserProfile: " . $e->getMessage());
            // Check for unique constraint violation (e.g., duplicate username/email if they are unique)
            if ($e->getCode() == 23000 && isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                return ['success' => false, 'message' => 'Username or email already exists.'];
            }

            // return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];

            return ['success' => false, 'message' => 'Failed to update profile due to a database error.'];
        }
    }
    public function deleteUserAndProfile($userId)
    {
        $query = "DELETE FROM " . $this->table . "
                    WHERE id=:userId;";

        $this->db->query($query);
        $this->db->bind('userId', $userId);
        $this->db->execute();
        if ($this->db->rowCount() === 0) {
            return [
                'success' => false,
                'message' => 'Failed to delete account.'
            ];
        } else {
            return [
                'success' => true,
                'message' => 'Your account has been deleted.'
            ];
        }
    }
}
