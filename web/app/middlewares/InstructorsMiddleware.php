<?php
class InstructorsMiddleware implements Middleware
{
    public function handle(array $params = []): bool
    {
        if ($_SESSION['user_role'] !== 'instructor') {
            Flasher::setFlash('This page can only be accessed by instructors.', 'danger');
            header('Location: ' . BASEURL . '/home');
            exit;
        }
        return true;
    }
}