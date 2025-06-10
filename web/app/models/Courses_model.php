<?php
class Courses_model
{
    private $table = 'courses';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function createNewCourse($data, $thumbnailFile, $instrId)
    {
        $newThumbnailPhotoName = null; // To store new uploaded photo name

        // --- Handle File Upload ---
        if ($thumbnailFile && $thumbnailFile['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../../public/img/thumbnail/";
            $fileTmpPath = $thumbnailFile['tmp_name'];
            $fileName = $thumbnailFile['name'];
            $fileSize = $thumbnailFile['size'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            $newFileName = uniqid() . '_' . basename($fileName); // Generate unique name
            $destPath = $uploadDir . $newFileName;

            // Basic validation for file type and size
            $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($fileExtension, $allowedFileExtensions)) {
                return [
                    'success' => false,
                    'message' => 'Only JPG, JPEG, PNG & WEBP files are allowed'
                ];
            }
            if ($fileSize > 5000000) // Max 5MB
            {
                return [
                    'success' => false,
                    'message' => 'Thumbnail picture is too big (max 5MB)'
                ];
            }
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                error_log("Failed to move uploaded file...");
                return ['success' => false, 'message' => 'Error uploading profile picture. Please try again.'];
            }
            $newThumbnailPhotoName = $newFileName ?? NULL;
        }

        $query = "INSERT INTO " . $this->table . "
                    (title, description, instructor_id, thumbnail_url)
                    VALUES (:title, :desc, :instrId, :thumbnail)";
        $this->db->query($query);
        $this->db->bind('title', $data['title']);
        $this->db->bind('desc', $data['description']);
        $this->db->bind('instrId', $instrId);
        $this->db->bind('thumbnail', $newThumbnailPhotoName);
        try {
            $this->db->execute();
            $courseId = $this->db->lastInsertId(); // Get the newly created user's ID

            return [
                'success' => true,
                'courseId' => $courseId
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'error_msg' => 'An unexpected error occurred.',
            ];
        }
    }
    public function loadCourse($courseId)
    {
        $query = "SELECT u.username as instr_uname, up.first_name, up.last_name, c.title, c.description, c.created_at, c.thumbnail_url
                FROM courses c
                JOIN users u ON c.instructor_id = u.id
                JOIN users_profile up ON u.id = up.user_id
                WHERE c.id = :courseId;";
        $this->db->query($query);
        $this->db->bind('courseId', $courseId);
        try {
            $result = $this->db->single();
            if ($result === false || $result === null) {
                return [
                    'success' => false,
                    'message' => 'Course does not exist.' // More specific error message
                ];
            }

            // Only proceed with date formatting if a course was found
            $result['created_at'] = date('l, d F Y', strtotime($result['created_at']));

            return [
                'success' => true,
                'course' => $result,
                'courseId' => $courseId
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'error_msg' => 'An unexpected error occurred.',
            ];
        }
    }
    public function loadCoursesCards($start)
    {
        $this->db->query("SELECT * FROM " . $this->table);
        $this->db->resultSet();
        $page_count = ceil($this->db->rowCount() / 6);

        $start = ($start - 1) * 6;
        $query = "SELECT c.id, c.title, c.thumbnail_url, up.first_name, up.last_name, u.username
                    FROM " . $this->table . " c
                    JOIN users u ON c.instructor_id = u.id
                    JOIN users_profile up ON u.id = up.user_id
                    ORDER BY c.id DESC
                    LIMIT 6 OFFSET :start";
        $this->db->query($query);

        $this->db->bind('start', $start);
        $cards = $this->db->resultSet();
        $item_count = $this->db->rowCount();

        return [
            'cards' => $cards,
            'pagesCount' => $page_count,
            'itemsCount' => $item_count
        ];
    }
    public function enrollCourse($userId, $courseId)
    {
        try {
            $query = "INSERT INTO enrollment (user_id, course_id)
                    VALUES (:userId, :courseId)";

            $this->db->query($query);
            $this->db->bind('userId', $userId);
            $this->db->bind('courseId', $courseId);

            $this->db->execute();

            return [
                'success' => true,
                'courseId' => $courseId,
                'message' => 'Enrollment successful!'
            ];
        } catch (PDOException $e) {
            error_log("Enrollment failed (PDOException): " . $e->getMessage());

            // Catch specific error codes for more detailed feedback
            // SQLSTATE 23000 (Integrity constraint violation) and MySQL error 1452 (Foreign key constraint fails)
            // will occur if user_id or course_id do not exist.
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1452) {
                return [
                    'success' => false,
                    'error' => $e->errorInfo[1],
                    'message' => 'Enrollment failed: User or course not found.'
                ];
            }
            // If you later add a UNIQUE constraint on (user_id, course_id),
            // this branch would then catch error code 1062 for duplicate entries.
            else if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                return [
                    'success' => false,
                    'error' => $e->errorInfo[1],
                    'message' => 'You are already enrolled in this course. (Duplicate Entry Error)'
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $e->errorInfo[1],
                    'message' => 'An unexpected error occurred during enrollment. Please try again later.'
                ];
            }
        }
    }
    public function isUserEnrolled(int $userId, int $courseId): bool
    {
        $query = "SELECT COUNT(*) FROM enrollment WHERE user_id = :userId AND course_id = :courseId";
        $this->db->query($query);
        $this->db->bind('userId', $userId);
        $this->db->bind('courseId', $courseId);
        $result = $this->db->single();
        return (int)$result['COUNT(*)'] > 0;
    }
    public function updateCourseData($courseId, array $courseData, ?array $thumbnailFile)
    {
        $title = htmlspecialchars($courseData['title']);
        $description = $courseData['description'];
        $newThumbnailPhotoName = null; // To store new uploaded photo name

        // --- Handle File Upload ---
        if ($thumbnailFile && $thumbnailFile['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../../public/img/thumbnail/";
            $fileTmpPath = $thumbnailFile['tmp_name'];
            $fileName = $thumbnailFile['name'];
            $fileSize = $thumbnailFile['size'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            $newFileName = uniqid() . '_' . basename($fileName); // Generate unique name
            $destPath = $uploadDir . $newFileName;

            // Basic validation for file type and size
            $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($fileExtension, $allowedFileExtensions)) {
                return [
                    'success' => false,
                    'message' => 'Only JPG, JPEG, PNG & WEBP files are allowed'
                ];
            }
            if ($fileSize > 5000000) // Max 5MB
            {
                return [
                    'success' => false,
                    'message' => 'Thumbnail picture is too big (max 5MB)'
                ];
            }
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                error_log("Failed to move uploaded file...");
                return ['success' => false, 'message' => 'Error uploading profile picture. Please try again.'];
            }
            // Fetch old photo filename
            $this->db->query("SELECT thumbnail_url
                                    FROM courses
                                    WHERE id = :courseId");
            $this->db->bind('courseId', $courseId);
            $currentThumbnail = $this->db->single();

            $oldThumbnailFile = $currentThumbnail['thumbnail_url'] ?? null;

            $newThumbnailPhotoName = $newFileName;
        }

        if ($newThumbnailPhotoName !== null && $oldThumbnailFile !== null) {
            $oldFilePath = __DIR__ . "/../../public/img/thumbnail/" . $oldThumbnailFile;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Delete old Thumbnail
            }
        }

        $query = "UPDATE " . $this->table . "
                    SET title = :title, description = :desc";
        if ($newThumbnailPhotoName !== null) {
            $query .= ", thumbnail_url = :thumbnail";
        }
        $query .= " WHERE id = :courseId";
        $this->db->query($query);
        $this->db->bind('courseId', $courseId);
        $this->db->bind('title', $title);
        $this->db->bind('desc', $description);
        if ($newThumbnailPhotoName !== null) {
            $this->db->bind('thumbnail', $newThumbnailPhotoName);
        }
        try {
            $this->db->execute();
            return [
                'success' => true,
                'message' => "Course updated successfully."
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'message' => 'Failed to update course.',
            ];
        }
    }
    public function deleteCourse($courseId)
    {

        // Fetch old photo filename
        $this->db->query("SELECT thumbnail_url
                                    FROM courses
                                    WHERE id = :courseId");
        $this->db->bind('courseId', $courseId);
        $result = $this->db->single();
        $profilePic = __DIR__ . "/../../public/img/thumbnail/" . $result['thumbnail_url']  ?? null;


        $query = "DELETE FROM " . $this->table . "
                    WHERE id=:courseId;";

        $this->db->query($query);
        $this->db->bind('courseId', $courseId);
        $this->db->execute();
        if ($this->db->rowCount() === 0) {
            return [
                'success' => false,
                'message' => 'Failed to delete account.'
            ];
        } else {
            if (file_exists($profilePic)) {
                unlink($profilePic); // Delete old photo
            }
            return [
                'success' => true,
                'message' => 'Your account has been deleted.'
            ];
        }
    }
}
