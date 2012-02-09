<?php
include('../function/global.php');
session_start();

do_html_header('Welcome to Book Shop Online');

echo '<p>Please choose a category.</p>';
$cat_arr = get_categories();
display_categories($cat_arr);

if (isset($_SESSION['admin_user']))
	display_button('admin/admin.php', 'admin-menu', 'Admin_menu');

do_html_footer();
?>
