<?php
include('../function/global.php');
session_start();

$new = $_GET['new'];

if ($new) {
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array();
		$_SESSION['items'] = 0;
		$_SESSION['total_price'] = '0.00';
	}

	if (isset($_SESSION['cart'][$new])) {
		$_SESSION['cart'][$new]++;
	} else {
		$_SESSION['cart'][$new] = 1;
	}

	$_SESSION['total_price'] = calculate_price($_SESSION['cart']);
	$_SESSION['items'] = calculate_items($_SESSION['cart']);
}

if (isset($_POST['save'])) {
	// TODO check user input 
	foreach ($_SESSION['cart'] as $isbn => $qty) {
		if ($_POST[$isbn] == 0) {
			unset($_SESSION['cart'][$isbn]);
		} else {
			$_SESSION['cart'][$isbn] = $_POST[$isbn];
		}
	}

	$_SESSION['total_price'] = calculate_price($_SESSION['cart']);
	$_SESSION['items'] = calculate_items($_SESSION['cart']);
}

do_html_header('Your shopping cart');

if (($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
	display_cart($_SESSION['cart']);
} else {
	echo '<p>There is no items in you cart</p>';
}

echo "<hr />";

$target = '/';
if ($new){
	$details = get_book_details($new);
	if ($details['catid'])
		$target = "show_cat.php?catid=" . $details['catid'];
}

display_button($target, 'continue-shopping', 'Continue Shopping');

// if SSL is set up
// then use following code
/*************************************
$path = $_SERVER['PHP_SELF'];
$server = $_SERVER['SERVER_NAME'];
$path = str_replace('show_cart.php', '', $path);
$target = "https://" . $server . $path . 'check_out.php';
display_button($target, 'go-to-checkout', 'Go To Checkout');
***************************************/

// if SSL is not set up
display_button('check_out.php', 'go-to-checkout', 'Go To Checkout');
?>
