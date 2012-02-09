<?php
include('../function/global.php');
session_start();

do_html_header('Check out');

$card_type = $_POST['card_type'];
$card_number = $_POST['card_number'];
$card_month = $_POST['card_month'];
$card_year = $_POST['card_year'];
$card_name = $_POST['card_name'];

if ( $_SESSION['cart'] && $card_type && $card_number && $card_month
				&& $card_year && $card_name) {
	display_cart($_SESSION['cart'], false, false);
	display_shipping(calculate_shipping_cost());

	if (process_card($_POST)) {
		if (!order_paid($_SESSION['order_id']))
			; // TODO some 
		session_destroy();
		echo "<p>Thank you for shopping with us. "
			. "Your order has been placed.";
		display_button('/', 'continue-shopping', 'Continue Shopping');
	} else {
		echo "<p>Could not process your card. Please contact the card
				issue or try again.</p>";
		display_button('check_out.php', 'back', 'Back');
	}
} else {
	echo "<p>You did not fill in all the fields, please try again.</p><hr />";
	display_button('purchase.php', 'back', 'Back');
}
?>
