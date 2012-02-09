<?php
require_once('../../function/global.php');
session_start();

do_html_header('Deleting book');

if (check_admin_user()) {
	if (isset($_POST['isbn'])) {
		if(delete_book($_POST['isbn'])) {
			echo "<p>Book was deleted.</p>";
		} else {
			echo "<p>Book could not been deleted.</p>";
		}
	} else {
		echo '<p>No book specified. Please try again.</p>';
	}
					
	do_html_url('admin.php', 'Back to administration menu');
} else {
	echo '<p>You are not authorized to enter the administration area.</p>';
}

do_html_footer();
?>
