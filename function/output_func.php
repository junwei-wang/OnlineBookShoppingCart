<?php
function do_html_header($title = '')
{
	// print HTML header
	if (!$_SESSION['items'])
		$_SESSION['items'] = 0;
	if (!$_SESSION['total_price'])
		$_SESSION['total_price'] = 0;
?>
<html>
<head>
  <title><?php echo $title; ?></title>
  <style>
    h2 { font-family: Arial, Helvetica, sans-serif; font-size:22px; color: red;
margin: 6px}
    body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; }
    li,td { font-family: Arial, Helvetica, sans-serif; font-size: 13px; }
	hr { color: #FF0000; width=70%; text-align:center }
	a { color: #000000 }
  </style>
</head>
<body>
  <table width='100%' border='0' cellspacing='0' bgcolor='#cccccc'>
  <tr>
    <td rowspan='2'>
	  <a href='/'><img src='/images/web/Book-O-Rama.gif' alt='Bookirama'
	    border='0' align='left' valign='bottom' height='55' width='325' /></a>
	</td>
	<td align='right' valign='bottom' height='28'>
<?php
	if (isset($_SESSION['admin_user'])) {
		echo '&nbsp;';
	} else {
		echo "Total Items = " . $_SESSION['items'];
	}
?>
	</td>
	<td align='right' rowspan='2' width='135'>
<?php
	if (isset($_SESSION['admin_user'])) {
		display_button('/admin/logout.php', 'log-out', 'Log Out');
	} else {
		display_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
	}
?>
	</td>
  </tr>
  <tr>
    <td align='right' valign='top'>
<?php
	if (isset($_SESSION['admin_user'])) {
		echo '&nbsp;';
	} else {
		echo "Total Price = <strong>$</strong>" 
				. number_format($_SESSION['total_price'], 2);
	}
?>
	</td>
  </tr>
  </table>

<?php
	if ($title)
		do_html_heading($title);
}

function do_html_footer()
{
?>
</body>
</html>
<?php
}

function do_html_heading ($title)
{
?>
<h2><?php echo $title; ?></h2>
<?php
}

function do_html_url ($url, $title)
{
	echo  '<a href="' . $url . '">' . $title . '</a><br />';
}

function display_categories($cat_arr)
{
	if (!is_array($cat_arr)) {
		echo "<p>No categories currently avaliable</p>";
		return;
	}
	
	echo "<ul>";
	foreach ($cat_arr as $cat) {
		$url = "show_cat.php?catid=" . $cat['catid'];
		$title = $cat['catname'];
		echo "<li>";
		do_html_url($url, $title);
		echo "</li>";
	}
	echo "</ul><hr />";
}

function display_books($books_arr)
{
	if (!is_array($books_arr)) {
		echo "<p>No books currently avaliable in this category.</p>";
		return;
	}

	echo '<table width="100%" border="0">';
	foreach ($books_arr as $book) {
		$isbn = $book['isbn'];
		$url = "show_book.php?isbn=$isbn";
		$pic = "images/book/$isbn.jpg";
		echo "<tr><td>";
		if (file_exists($pic)) {
			$title = '<img src="' . $pic . '" '
					. 'style="border: 1px solid black" />';
			do_html_url($url, $title);
		} else {
			echo "&nbsp;";
		}
		echo '</td><td>';
		$title = $book['title'];
		do_html_url($url, $title);
		echo "by " . $book['author'];
		echo "</td></tr>";
	}
	echo '</table><hr >';
}

function display_book_details($book)
{
	if (is_array($book)) {
		echo "<table><tr>";
		$pic = 'images/book/' . $book['isbn'] . '.jpg';
		if (@file_exists($pic)) {
			$size = GetImageSize($pic);
			if ($size[0] > 0 && $size[1] >0)
				echo '<td><img src="' . $pic . '" ' 
					. 'style="border:1 px solid black" /></td>';
		}
		echo "<td><ul>";
		echo "<li><strong>Author:&nbsp;</strong>" . $book['author'] . "</li>";
		echo "<li><strong>ISBN:&nbsp;</strong>" . $book['isbn'] . "</li>";
		echo "<li><strong>Our Price:&nbsp;$</strong>" . $book['price'] . "</li>";
		echo "<li><strong>Description:&nbsp;</strong>" . $book['description'] . "</li>";
		echo "</ul></td></tr></table>";
	} else {
		echo '<p>The details of this book cannot be displayed at this time.</p>';
	}
	echo "<hr />";
}

function display_button($target, $image, $alt)
{
	echo '<div align="center"><a href="' . $target . '">' .
		'<img src="/images/web/' . $image . '.gif" alt="' . $alt 
		.'" height="50" width="135" /></a></div>';
}

function display_cart($cart, $change = true, $images = true) 
{
	// display items in shopping cart
	// optionally allow change (true or false)
	// optionally allow include images (true or false)
?>
<table border='0' width='100%' cellspacing='0' >
<form action='show_cart.php' method='post'>
  <tr bgcolor="#cccccc">
<?php

	// display title
	if ($images) { 
		echo '<th colspan="2">Item</th>';
	} else {
		echo '<th>Item</th>';
	}
?>
  <th>Price</th>
  <th>Quantity</th>
  <th align='right'>Total</th>
  </tr>
<?php

	// display items
	foreach ($cart as $isbn => $qty) {
		$book = get_book_details($isbn);
		$pic = "images/book/$isbn.jpg";
		echo "<tr>";
		if ($images) {
			echo "<td align='left'>";
			if (file_exists($pic)) {
				$size = GetImageSize($pic);
				if ($size[0]>0 && $size[1]>0)
					echo '<img src="' . $pic . '" ' 
						. 'style="border : 1px solid black" '
						. 'width="' . $size[0]/3 . '" '
						. 'height="' . $size[1]/3 . '"/>';
			} else {
				echo '&nbsp;';
			}
			echo "</td>";
		}
?>
	<td align='left'>
	  <a href='show_book.php?isbn=<?php echo $isbn; ?>'/>
	  <?php echo $book['title']; ?></a><br />
	  by&nbsp;<?php echo $book['author'] ?>
	</td>
	<td align='center'>
	  <strong>$</strong><?php echo number_format($book['price'], 2); ?>	  
	</td>
	<td align='center'>
<?php
	// if num of items can be changed
		if ($change) {
			echo "<input type='text' name='" . $isbn . "' value='" . $qty 
				. "' size='2'>";
		} else {
			echo $qty;
		}
?>
	<td align='right'>
	  <strong>$</strong><?php echo number_format($book['price']*$qty, 2); ?>
	</td>
	</tr>
<?php
	}
	// display total row
?>
	<tr bgcolor='#cccccc' align='center'>
	<th colspan="
<?php
		if ($images) {
			echo 3;
		} else {
			echo 2;
		}
?>"	
		>&nbsp;</th>
	<th><?php echo $_SESSION['items']; ?></th>
	<th align='right'>$<?php echo number_format($_SESSION['total_price'], 2); ?></th>
	</tr>
<?php
	if ($change) {
		$colspan = 2;
		if ($images)
			$colspan =3;
?>
	<tr>
	  <td colspan="<?php echo $colspan; ?>">&nbsp;</td>
	  <td align='center' colspan='2' >
	    <input type='hidden' name='save' value='true' />
	    <input type='image' src='images/web/save-changes.gif' value='true' 
			border='0' alt='Save Changes' />
	  </td>
	</tr>
<?php
	}

?>
</form>
</table>
<?php
}

function display_checkout_form()
{
	// display the form as for name and address
?>
<br />
<table border='0' width='100%' cellspacing='0'>
<form action='purchase.php' method='post'>
  <tr>
    <th colspan='2' bgcolor='#cccccc'>Your Details</th>
  </tr>
  <tr>
    <td align='right'>Name:</td>
    <td><input type='text' name='name' value='' maxlength='40' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>Address:</td>
    <td><input type='text' name='address' value='' maxlength='40' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>City/Suburb:</td>
    <td><input type='text' name='city' value='' maxlength='20' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>State/Province:</td>
    <td><input type='text' name='state' value='' maxlength='20' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>Postal Code/Zip Code:</td>
    <td><input type='text' name='zip' value='' maxlength='10' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>Country:</td>
    <td><input type='text' name='country' value='' maxlength='20' size='40' /></td>
  </tr>
  <tr>
    <th colspan='2' bgcolor='#cccccc'>Shipping Address 
			(leave blank if as above)</th>
  </tr>
  <tr>
    <td align='right'>Name:</td>
    <td><input type='text' name='ship_name' value='' maxlength='40' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>Address:</td>
    <td><input type='text' name='ship_address' value='' maxlength='40' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>City/Suburb:</td>
    <td><input type='text' name='ship_city' value='' maxlength='20' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>State/Province:</td>
    <td><input type='text' name='ship_state' value='' maxlength='20' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>Postal Code/Zip Code:</td>
    <td><input type='text' name='ship_zip' value='' maxlength='10' size='40' /></td>
  </tr>
  <tr>
    <td align='right'>Country:</td>
    <td><input type='text' name='ship_country' value='' maxlength='20' size='40' /></td>
  </tr>
  <tr>
    <td colspan='2' align='center'>
	  <p><strong>Please press <em>Purchase</em> to confirm your purchase, or 
	  <em>Continue Shopping</em> to add or remove items.</strong></p>
	   <?php display_form_button('purchase', "Purchase These Itens"); ?>
	</td>
  </tr>
</form>
</table><hr />
<?php
}

function display_form_button ($image, $alt)
{
?>
	<div align='center'>
	<input type='image' src='images/web/<?php echo $image; ?>.gif'
		alt='<?php echo $alt; ?>' border='0' height='50' width='135' />
	</div>
<?php 
}

function display_shipping($cost)
{
?>
<table border='0' width='100%' cellspacing='0'>
<tr>
  <td align='left'>Shipping</td>
  <td align='right'>
  <strong>$</strong><?php echo number_format($cost, 2); ?>
  </td>
</tr>
<tr>
  <th bgcolor='#cccccc' align='left'>TOTAL INCLUDING SHIPPING</th>
  <th bgcolor='#cccccc' align='right'>
  <strong>$</strong><?php echo number_format($cost+$_SESSION['total_price'], 2); ?>
  </th>
</tr>
</table>

<?php
}

function display_card_form($name)
{
	// display form for asking credit card details
?>
<table border='0' width='100%' cellspacing='0'>
<form action='process.php' method='post'>
  <tr>
    <th colspan='2' bgcolor="#cccccc">Credit Card Details</th>
  </tr>
  <tr>
    <td align='right'>Type:</td>
	<td>
	  <select name='card_type'>
	  <option value='VISA'>VISA</option>
	  <option value='MasterCard'>MasterCard</option>
	  <option value='American Express'>American Express</option>
	  </select>
	</td>
  </tr>
  <tr>
    <td align='right'>Number:</td>
	<td>
	 <input type='text' name='card_number' value='' maxlength='16' size='40'>
	</td>
  </tr>
  <tr>
    <td align='right'>AMEX code (if required):</td>
	<td>
	 <input type='text' name='amex_code' value='' maxlength='4' size='4'>
	</td>
  </tr>
  <tr>
    <td align='right'>Expiry Date:</td>
	<td>Month
	  <select name='card_month'>
	    <option value='01'>01</option>
	    <option value='02'>02</option>
	    <option value='03'>03</option>
	    <option value='04'>04</option>
	    <option value='05'>05</option>
	    <option value='06'>06</option>
	    <option value='07'>07</option>
	    <option value='08'>08</option>
	    <option value='09'>09</option>
	    <option value='10'>10</option>
	    <option value='11'>11</option>
	    <option value='12'>12</option>
	  </select>
	  Year
	  <select name='card_year'>
<?php
		for ($year=date('Y'); $year<date('Y')+10; $year++) {
			echo '<option value="' . $year . '">' . $year . '</option>';
		}
?>
	  </select>
	</td>
  </tr>
  <tr>
    <td align='right'>Name on Card:</td>
	<td>
	  <input type='text' name='card_name' value='<?php echo $name; ?>' 
	  			maxlength='40' size='40'>
	</td>
  </tr>
  <tr>
    <td colspan='2' align='center'>
	  <p><strong>Please press <em>Purchase</em> to confirm your purchase, or
	  <em>Continue Shopping</em> to add or remove items.</em></strong></p>
	  <?php display_form_button('purchase', 'Purchase These Items'); ?>
	</td>
  </tr>
</form>
</table>
<?php
}

function display_login_form()
{
?>
<form method="post" action="admin.php">
 <table bgcolor="#cccccc">
   <tr>
     <td>Username:</td>
     <td><input type="text" name="username"/></td></tr>
   <tr>
     <td>Password:</td>
     <td><input type="password" name="passwd"/></td></tr>
   <tr>
     <td colspan="2" align="center">
     <input type="submit" value="Log in"/></td></tr>
   <tr>
</table></form>
<?php
}

function display_admin_menu() 
{
?>
	<br />
	<a href='/'>Go to mian site</a><br />
	<a href='insert_category_form.php'>Add a new category</a><br />
	<a href='insert_book_form.php'>Add a new book</a><br />
	<a href='change_password_form.php'>Change admin password</a><br />

<?php
}
?>
