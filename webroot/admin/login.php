<?php
include('../../function/global.php');
session_start();

if (check_admin_user()) {
	require('admin.php');
	echo '<br/><br />You have been logged in.';
	exit;
}
do_html_header('Administration');

display_login_form();

do_html_footer();
?>
