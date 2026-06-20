<?php

function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

startSession();

function isLoggedIn() {
    return isset($_SESSION['id_user']);
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function requireLogin($redirectTo = '/auth/login-user.php') {
    if (!isLoggedIn()) {
        header('Location: ' . $redirectTo);
        exit;
    }
}

function requireRole($role, $loginRedirect = '/auth/login-user.php') {
    if (!isLoggedIn()) {
        header('Location: ' . $loginRedirect);
        exit;
    }

    if (getUserRole() !== $role) {
        header('Location: /auth/logout.php');
        exit;
    }
}
