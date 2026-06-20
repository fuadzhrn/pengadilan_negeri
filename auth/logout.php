<?php
require_once dirname(__DIR__) . '/config/auth.php';

session_unset();
session_destroy();

session_start();
$_SESSION['success'] = 'Anda berhasil logout.';

header('Location: ' . BASE_URL . '/public/index.php');
exit;
