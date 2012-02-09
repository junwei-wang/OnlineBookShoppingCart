<?php

function get_categories()
{
	if (!$conn = db_connect())
		return false;
	$sql = 'select catid, catname from tblCategory';
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	$num_cats = @$result->num_rows;
	if ($num_cats == 0)
		return false;

	return db_result_to_array($result);
}

function get_category_name($catid)
{
	if (!$conn = db_connect())
		return false;
	$sql = 'select catname from tblCategory where catid=' . $catid;
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	$num_cats = @$result->num_rows;
	if ($num_cats == 0)
		return false;
	$row = $result->fetch_object();
	return $row->catname;
}

function get_books($catid)
{
	if (!$conn = db_connect())
		return false;
	$sql = 'select isbn, author, title from tblBook '
			. ' where catid=' . $catid;
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	$num_books = @$result->num_rows;
	if ($num_books == 0)
		return false;

	return db_result_to_array($result);
}

function get_book_details($isbn)
{
	if ((!$isbn) || ($isbn) == '')
		return false;
	$conn = db_connect();
	$sql = 'select isbn, author, title, catid, price, description from '
			. 'tblBook where isbn="' . $isbn . '"';
	$result = @$conn->query($sql);

	if (!$result)
		return false;

	$result = @$result->fetch_assoc();
	return $result;
}

function calculate_price($cart) 
{
	$price = 0.0;
	if (is_array($cart)) {
		$conn = db_connect();
		foreach ($cart as $isbn => $qty) {
			$sql = 'select price from tblBook where isbn=' . $isbn;
			$result = $conn->query($sql);
			if ($result) {
				$item = $result->fetch_object();
				$item_price = $item->price;
				$price += $item_price * $qty;
			}
		}
	}
	return $price;
}

function calculate_items ($cart) 
{
	$cnt = 0;
	if (is_array($cart)) 
		foreach ($cart as $isbn => $qty) 
			$cnt += $qty;
	return $cnt;
}

function calculate_shipping_cost() 
{
	// assume that the cost is fixed
	return 20.00;
}
?>
