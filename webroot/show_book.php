<?php
include('../function/global.php');
session_start();

$isbn = $_GET['isbn'];
if (!isset($isbn)) {
	do_html_header('No book select!');
	display_button('/', 'continue-shopping', "Continue Shopping");
	do_html_footer();
	exit;
}

$book = get_book_details($isbn);
do_html_header($book['title']);
display_book_details($book);

$target = 'index.php';
if ($book['catid'])
	$target = 'show_cat.php?catid=' . $book['catid'];

if (check_admin_user()) {
	display_button("admin/edit_book_form.php?isbn=$isbn", "edit-item", "Edit Item");
	display_button('admin/admin.php', 'admin-menu', 'Admin Menu');
	display_button($target, 'continue', "Continue");
} else {
	display_button('show_cart.php?new=' . $isbn, 'add-to-cart', 
					"Add " . $book['title'] . "To My Shopping Cart");
	display_button($target, 'continue-shopping', "Continue Shopping");
}

do_html_footer();
?>
