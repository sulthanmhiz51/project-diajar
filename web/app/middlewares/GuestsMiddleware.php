<?php

class GuestsMiddleware implements Middleware
{
    public function handle(array $params = []): bool
    {
        if (isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
        return true;
    }
}
