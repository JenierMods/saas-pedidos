<?php

class LandingController {

    public function index() {
        if (isLoggedIn()) redirect('/panel');
        require BASE_PATH . '/views/landing/index.php';
    }
}
