<?php

function db_connect()
{
	$result = new mysqli('localhost', 'book_sc', 'book_sc', 'book_sc');
	if (!$result)
		return false;
	$result->autocommit(TRUE);
	return $result;
}

function db_result_to_array($result)
{
	$res_arr = array();
	$count = 0;

	while ($row = $result->fetch_assoc())
		$res_arr[$count++] = $row;

	return $res_arr;
}
?>
