<?php
include('../function/global.php');
session_start();

do_html_header('Check Out');

$cart = $_SESSION['cart'];
if ($cart && array_count_values($cart)) {
	display_cart($cart, false, false);
	display_checkout_form();	
} else {
	echo '<p>There is no item in you cart.<p>';
}

display_button('show_cart.php', 'continue-shopping', 'Continue Shopping');
do_html_footer();
?>
