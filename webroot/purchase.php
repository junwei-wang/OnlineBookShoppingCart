<?php
include('../function/global.php');
session_start();

do_html_header('Check Out');

// TODO check user data
$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$zip = $_POST['zip'];
$country = $_POST['country'];

if ($_SESSION['cart'] && $name && $address && $city && $zip && $country) {
	if ($_SESSION['order_submitted']) {
		display_cart($_SESSION['cart'], false, false);

		display_shipping(calculate_shipping_cost());
		
		display_card_form($name);

		display_button('show_cart.php', 'continue-shopping', 
						'Continue Shopping');
	}else if ( ($order_id = insert_order($_POST)) != false ) {
		$_SESSION['order_submitted'] = true;
		$_SESSION['order_id'] = $order_id;
		display_cart($_SESSION['cart'], false, false);

		display_shipping(calculate_shipping_cost());
		
		display_card_form($name);

		display_button('show_cart.php', 'continue-shopping', 
						'Continue Shopping');
	} else {
		echo "<p>Could not store data, please try again.</p>";
		display_button('check_out.php', 'back', 'Back');
	}
	
} else {
	echo "<p>You did not fill in all the fields, please try again.</p><hr />";
	display_button('check_out.php', 'back', 'Back');
}

do_html_footer();
?>
