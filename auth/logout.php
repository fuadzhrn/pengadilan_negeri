<?php
session_start();
session_unset();
session_destroy();

session_start();
$_SESSION['success'] = 'Anda berhasil logout.';

header('Location: /public/index.php');
exit;
