<?php
	include('../function/global.php');
	session_start();

	$catid = $_GET['catid'];
	
	if (!isset($catid)) {
		do_html_header('Please choose a category.');
		$cat_arr = get_categories();
		display_categories($cat_arr);
		if (isset($_SESSION['admin_user']))
			display_button('admin/admin.php', 'admin_menu', 'Admin_menu');
	} else {
		$catname = get_category_name($catid);
		do_html_header($catname);
		$book_arr = get_books($catid);
		display_books($book_arr);
		if (isset($_SESSION['admin_user'])) {
			display_button('index.php', 'continue', 'Continue Shopping');
			display_button('admin/admin.php', 'admin-menu', 'Admin_menu');
			display_button('admin/edit_category_form.php?catid=' . $catid,
							'edit-category', 'Edit Category');
		} else {
			display_button('index.php', 'continue-shopping', 'Continue Shopping');
		}
	}
do_html_footer();
?>

