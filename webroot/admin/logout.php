<?php
include('../../function/global.php');
session_start();

$old_user = $_SESSION['admin_user'];
unset($_SESSION['admin_user']);

do_html_header('Loggin out');

if (!empty($old_user)) {
	echo '<p>Logged out.</p>';
	do_html_url('login.php', 'Login');
} else {
	echo "<p>You were not logged in, and so have not been logged out.</p>";
	do_html_url("login.php", "Login");
}

do_html_footer();
?>
