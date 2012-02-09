<?php
require_once('../../function/global.php');
session_start();

do_html_header('Updating category');

if (check_admin_user()) {
	if (filled_out($_POST)) {
		if(update_category($_POST['catid'], $_POST['catname'])) {
			echo "<p>Category was updated.</p>";
		} else {
			echo "<p>Category could not been updated.</p>";
		}
	} else {
		echo '<p>You have not filled out the form. Please try again.</p>';
	}
					
	do_html_url('admin.php', 'Back to administration menu');
} else {
	echo '<p>You are not authorized to enter the administration area.</p>';
}

do_html_footer();
?>
