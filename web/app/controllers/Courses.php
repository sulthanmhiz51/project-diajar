<?php

class Courses extends Controller
{
    protected $middleware = [
        ['InstructorsMiddleware', ['create']]
    ];
    public function index()
    {
        $data['judul'] = 'Courses';
        $page = $_GET['page'] ?? 1;
        $cards = $this->model('Courses_model')->loadCoursesCards($page);

        $this->view('templates/header', $data);
        $this->view('courses/index', $cards);
        $this->view('templates/footer');
    }

    public function detail()
    {
        if (!isset($_GET['courseId'])) {
            header('Location: ' . BASEURL . '/courses/index');
        }
        $course = $this->model('Courses_model')->loadCourse($_GET['courseId']);
        $data['judul'] = 'Course Detail';
        $data['enrolled'] = $this->model('Courses_model')->isUserEnrolled($_SESSION['user_id'], $_GET['courseId']);
        $data['course'] = $course['course'];

        if ($course['success'] == false) {
            Flasher::setFlash($course['message'],  "danger");
            header('Location: ' . BASEURL . '/courses');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('courses/detail', $data);
        $this->view('templates/footer');
    }
    public function create()
    {
        $data['judul'] = 'Create Course';

        $this->view('templates/header', $data);
        $this->view('courses/create');
        $this->view('templates/footer');
    }

    public function createCourse()
    {
        $result = $this->model('Courses_model')->createNewCourse($_POST, $_FILES['thumbnail'], $_SESSION['user_id']);
        if ($result['success'] == true) {
            Flasher::setFlash('Course has been successfully created.', 'success');
            header('Location: ' . BASEURL . '/courses/detail?courseId=' . $result['courseId']);
            exit;
        } else {
            Flasher::setFlash($result['error_msg'],  "danger");
            header('Location: ' . BASEURL . '/courses/create?error=' . $result['error']);
            exit;
        }
    }
    public function enroll()
    {
        $result = $this->model('Courses_model')->enrollCourse($_SESSION['user_id'], $_GET['courseId']);
        if ($result['success'] == true) {
            Flasher::setFlash($result['message'], 'success');
            header('Location: ' . BASEURL . '/courses/detail?courseId=' . $result['courseId']);
            exit;
        } else {
            Flasher::setFlash($result['message'],  "danger");
            header('Location: ' . BASEURL . '/courses?error=' . $result['error']);
            exit;
        }
    }
    public function editCourse($courseId)
    {
        // Fetch existing course data to pre-fill the form
        $courseData = $this->model('Courses_model')->loadCourse($courseId); // Re-use your loadCourse method

        if ($courseData['success'] && $courseData['course']) {
            $this->view('courses/edit', ['course' => $courseData['course'], 'courseId' => $courseData['courseId']]);
        } else {
            // Handle case where course is not found, perhaps render an error message partial
            echo '<div class="alert alert-warning">Course not found for editing.</div>';
        }
    }
    public function updateCourse($courseId)
    {
        // Set content type to JSON
        header('Content-Type: application/json');

        // Basic validation for POST and AJAX request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method or not an AJAX request.']);
            exit;
        }

        // Prepare data for the model from $_POST   
        $courseData = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
        ];

        // Pass the $_FILES['profilePicture'] array directly to the model
        $thumbnailFile = $_FILES['thumbnail'] ?? null;

        // Call the model to handle the update logic, including file upload
        $updateResult = $this->model('Courses_model')->updateCourseData(
            $courseId,
            $courseData,
            $thumbnailFile
        );

        // Respond to the AJAX request based on the model's result
        if ($updateResult['success']) {

            echo json_encode([
                'success' => true,
                'message' => $updateResult['message']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $updateResult['message']]);
        }
        exit;
    }
    public function deleteCourse($courseId)
    {
        $result = $this->model('Courses_model')->deleteCourse($courseId);
        echo json_encode($result);
    }
}
