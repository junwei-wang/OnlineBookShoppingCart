<?php
function insert_order($order_details)
{
	// extract order_details out as variables
	extract($order_details);

	// TODO check user data
	if ( !$ship_name ) {
		$ship_name = $name;
	}
	if (!$ship_address) {
		$ship_address = $address;
	}
	if (!$ship_city) {
		$ship_city = $city;
	}
	if (!$ship_state) {
		$ship_state = $state;
	}
	if (!$ship_zip) {
		$ship_zip = $zip;
	}
	if (!$ship_country) {
		$ship_country = $country;
	}

	$conn = db_connect();
	$conn->autocommit(false);

	$sql = "select customerid from tblCustomer where name='$name' and "
		. "address='$address' and city='$city' and state='$state' and "
		. "zip='$zip' and country='$country'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$customer = $result->fetch_object();
		$customerid = $customer->customerid;
	} else {
		$sql = "insert into tblCustomer values ('','$name','$address',"
			. "'$city','$state','$zip','$country')";
		$result = $conn->query($sql);
		if (!$result)
			return false;
		$customerid = $conn->insert_id;
	}

	date_default_timezone_set('UTC');
	$date = date('Y-m-d', time());
	$sql = "insert into tblOrder values ('','$customerid','" 
		. $_SESSION['total_price'] . "','$date','NOT_PAID','$ship_name',"
		. "'$ship_address','$ship_city','$ship_state','$ship_zip',"
		. "'$ship_country')";
	$result = $conn->query($sql);
	if (!$result)
		return false;

	$cost = $_SESSION['total_price'];
	$sql = "select orderid from tblOrder where customerid='$customerid' and "
		. "amount between " . ($cost-0.001) . " and " . ($cost+0.001) 
		. " and date='$date' and "
		. "order_status='NOT_PAID' and ship_name='$ship_name' and "
		. "ship_address='$ship_address' and ship_city='$ship_city' and "
		. "ship_state='$ship_state' and ship_zip='$ship_zip' and "
		. "ship_country='$ship_country'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$order = $result->fetch_object();
		$orderid = $order->orderid;
	} else {
		return false;
	}

	foreach ($_SESSION['cart'] as $isbn => $qty){
		$details = get_book_details($isbn);
		$price = $details['price'];
		$sql = "insert into tblOrderItem values ('$orderid','$isbn','$price',"
			. "'$qty')";
		$result = $conn->query($sql);
		if (!$result)
			return false;
	}

	$conn->commit();
	$conn->autocommit(true);
	
	return $orderid;
}

function process_card($cart_details) 
{
	// connect to credit card suppliment for more
	
	return true;
}

function order_paid($orderid)
{
	$conn = db_connect();
	$sql = 'update tblOrder set order_status="PAID"';
	$result = $conn->query($sql);
	if (!$result)
		return false;
	return true;
}
?>
