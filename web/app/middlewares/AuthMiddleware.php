<?php

class AuthMiddleware implements Middleware
{
    public function handle(array $params = []): bool
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            Flasher::setFlash('You need to log in to access this page.', 'danger');
            header('Location: ' . BASEURL . '/users/auth');
            exit;
        }
        return true;
    }
}
