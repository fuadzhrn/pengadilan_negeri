<?php

// BASE_URL menyesuaikan otomatis baik diakses lewat virtual host (root domain)
// maupun lewat subfolder seperti http://localhost/pengadilan_negeri/
if (!defined('BASE_URL')) {
    $project_root = str_replace('\\', '/', dirname(__DIR__));
    $doc_root = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/\\')) : '';

    $base_url = '';
    if ($doc_root !== '' && stripos($project_root, $doc_root) === 0) {
        $base_url = substr($project_root, strlen($doc_root));
    }

    define('BASE_URL', rtrim($base_url, '/'));
}

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
        header('Location: ' . BASE_URL . $redirectTo);
        exit;
    }
}

function requireRole($role, $loginRedirect = '/auth/login-user.php') {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . $loginRedirect);
        exit;
    }

    if (getUserRole() !== $role) {
        header('Location: ' . BASE_URL . '/auth/logout.php');
        exit;
    }
}
