<?php
require_once('../../function/global.php');
session_start();

do_html_header('Adding a book');

if (check_admin_user()) {
	if (!filled_out($_POST)) {
		echo '<p>You have not filled out the form. Please try again.</p>';
	} else {
		// todo check user data
		$isbn = $_POST['isbn'];
		$title = $_POST['title'];
		$author = $_POST['author'];
		$catid = $_POST['catid'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		if (insert_book($isbn, $title, $author, $catid, $price, $description)) {
			echo "<p>Book <em>" . stripslashes($catname) 
					."</em> was added to the database.</p>";
		} else {
			echo "<p>Book <em>" . stripslashes($catname) 
					."</em> could not be added to the database.</p>";
		}
	}
	do_html_url('admin.php', 'Back to administration menu');
} else {
	echo '<p>You are not authorized to enter the administration area.</p>';
}

do_html_footer();
?>
