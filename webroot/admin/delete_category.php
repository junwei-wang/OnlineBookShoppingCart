<?php
require_once('../../function/global.php');
session_start();

do_html_header('Deleting category');

if (check_admin_user()) {
	if (isset($_POST['catid'])) {
		if(delete_category($_POST['catid'])) {
			echo "<p>Category was deleted.</p>";
		} else {
			echo "<p>Category could not been deleted.</p>";
		}
	} else {
		echo '<p>No category specified. Please try again.</p>';
	}
					
	do_html_url('admin.php', 'Back to administration menu');
} else {
	echo '<p>You are not authorized to enter the administration area.</p>';
}

do_html_footer();
?>
