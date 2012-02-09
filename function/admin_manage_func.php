<?php
function insert_category($catname)
{
	$conn = db_connect();
	$sql = "select catname from tblCategory where catname='$catname'";
	$result = $conn->query($sql);
	if (!$result || $result->num_rows!=0)
		return false;

	$sql = "insert into tblCategory values ('', '$catname')";
	$result = $conn->query($sql);

	if (!$result)
		return false;

	return true;
}

function update_category ($catid, $catname)
{
	$conn = db_connect();
	$sql = "update tblCategory set catname='$catname' where catid='$catid'";
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	return true;
}

function delete_category ($catid)
{
	$conn = db_connect();
	$sql = "select isbn from tblBook where catid='$catid'";
	$result = @$conn->query($sql);
	if (!$result || $result->num_rows>0)
		return false;

	$sql = "delete from tblCategory where catid='$catid'";
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	return true;
}

function insert_book ($isbn, $title, $author, $catid, $price, $description)
{
	$conn = db_connect();
	$sql = "select isbn from tblBook where isbn='$isbn'";
	$result = $conn->query($sql);
	if (!$result || $result->num_rows!=0)
		return false;
	$sql = "insert into tblBook values ('$isbn', '$title', '$author',"
			. "'$catid', '$price', '$description')";
	$result = $conn->query($sql);

	if (!$result)
		return false;

	return true;
}

function update_book ($oldisbn, $isbn, $title, $author, $catid, $price, 
				$description)
{
	$conn = db_connect();
	$sql = "update tblBook set isbn='$isbn', title='$title', author='$author',"
		. "catid='$catid',price='$price',description='$description' "
		. "where isbn='$oldisbn'";
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	return true;
}

function delete_book ($isbn)
{
	$conn = db_connect();
	$sql = "delete from tblBook where isbn='$isbn'";
	$result = @$conn->query($sql);
	if (!$result)
		return false;

	return true;
}
?>
