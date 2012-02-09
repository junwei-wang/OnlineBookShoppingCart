<?php
require_once('../../function/global.php');
session_start();

do_html_header('Add a book');

if (check_admin_user()) {
	display_book_form();
	do_html_url('admin.php', 'Back to administration menu');
} else {
	echo '<p>You are not authorized to enter the administration area.</p>';
}

do_html_footer();
?>
