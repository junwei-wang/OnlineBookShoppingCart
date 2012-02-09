<?php

function display_password_form()
{
?>
 <br />
   <form action="change_password.php" method="post">
   <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Old password:</td>
       <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>New password:</td>
       <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>Repeat new password:</td>
       <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
   </tr>
   <tr><td colspan=2 align="center"><input type="submit" value="Change password">
   </td></tr>
   </table>
   <br />
<?php
}

function display_category_form($category = '') 
{
	// This display the category form 
	// This form can be used for inserting or editing categries

	// To insert, don't pass any parameters 
	// To update, pass an array containing a category
	$edit = is_array($category);
?>
<form method='post' 
      action='<?php echo $edit?'edit_category.php':'insert_category.php'; ?>'>
<table border='0'>
  <tr>
    <td>Category Name:</td>
	<td><input type='text' name='catname' size='40' maxlength='40' 
	           value='<?php echo $edit?$category['catname']:''; ?>' /></td>
  </tr>
    <td <?php if (!$edit) echo "colspan='2'"; ?> align='center'>
<?php
if ($edit)
	echo "<input type='hidden' name='catid' value='" . $category['catid']
		. "' />";
?>
	  <input type='submit' 
	         value="<?php echo $edit?'Rename':'Add'; ?> Category" /></form>
	</td>
<?php
	if ($edit)
		echo '<form method="post" action="delete_category.php">
				<td align="center">
				<input type="hidden" name="catid" value="' . $category['catid'] .'" />
				<input type="submit" value="Delete Category" />
			 	</td>
			</form>';
?>
  <tr>
  </tr>
</table>
<?php
}

function display_book_form($book = '')
{
	// This display the book form
	// It is very similar to display_category_function
	// This can be used for inserting or editing book

	// To insert, don't pass any parameters.
	// To edit , pass an array contains a book
	$edit = is_array($book);
?>
<form method='post'
      action='<?php echo $edit?'edit_book.php':'insert_book.php'; ?>'>
<table border='0'>
<tr>
  <td align='right'>ISBN:</td>
  <td><input type='text' name='isbn' 
             value='<?php echo $edit?$book['isbn']:''; ?>' /></td>
</tr> 
<tr>
  <td align='right'>Book Title:</td>
  <td><input type='text' name='title' 
             value='<?php echo $edit?$book['title']:''; ?>' /></td>
</tr> 
<tr>
  <td align='right'>Book Author:</td>
  <td><input type='text' name='author' 
             value='<?php echo $edit?$book['author']:''; ?>' /></td>
</tr> 
<tr>
  <td align='right'>Category:</td>
  <td><select name='catid'>
<?php
    $cat_arr = get_categories();
	foreach ($cat_arr as $cat) {
		echo "<option value='" . $cat['catid'] . "'";
		if (($edit) && ($cat['catid'] == $book['catid'])) {
			echo " selected='selected'";
		}
		echo ">" . $cat['catname'] . "</option>";
	}
?>
  </select>
  </td>
</tr> 
<tr>
  <td align='right'>Price ($):</td>
  <td><input type='text' name='price' 
             value='<?php echo $edit?$book['price']:''; ?>' /></td>
</tr> 
<tr>
  <td align='right'>Description:</td>
  <td><textarea rows='5' cols='50' name='description'><?php 
      echo $edit?$book['description']:''; ?></textarea></td>
</tr> 
<tr>
  <td <?php if (!$edit) echo 'colspan=2'; ?> align='center' >
    <?php
	if ($edit)
		echo "<input type='hidden' name='oldisbn' value='" 
			. $book['isbn'] . "' />";
	?>
	<input type='submit'
	       value='<?php echo $edit?'Update':'Add'; ?> Book' />
  </td></form>
  <?php
    if ($edit) {
		echo "<form method='post' action='delete_book.php'>
			   <td>
			   <input type='hidden' name='isbn' value='" . $book['isbn'] . "'>
			   <input type='submit' value='Delete Book'>
			   <td/>
			  </form>";
	}
  ?>
</tr>


</table>
<?php
}

?>
