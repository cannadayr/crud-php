<?php
session_start();
$script = $_SERVER['SCRIPT_NAME'];
$server = $_SERVER['REQUEST_URI'];

//INITIALIZE SESSION VARIABLES
if (!isset($_SESSION['items'])) {
	$_SESSION['items'] = array();
}

//_GET VARIABLES
if ($_REQUEST) {
	if (isset($_REQUEST['add_item'])) {
		$_SESSION['items'][] = $_REQUEST['add_item_txt'];
		header("Location:$script");
	} elseif (isset($_REQUEST['edit_item']) && isset($_REQUEST['edit_item_txt'])) {
		$id = $_REQUEST['edit_item'];
		$_SESSION['items'][$id] = $_REQUEST['edit_item_txt'];
		header("Location:$script");
	} elseif (isset($_REQUEST['delete_item'])) {
		$id = $_REQUEST['delete_item'];
		array_splice($_SESSION['items'], $id, 1);
		header("Location:$script");
	} elseif (isset($_REQUEST['delete_all_items'])) {
		$_SESSION['items'] = array();
		header("Location:$script");
	}
}
//OUTPUT PAGE
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<table>
		<?php foreach ($_SESSION['items'] as $key => $val): ?>
			<tr>
				<?php if (isset($_REQUEST['edit_item']) && $_REQUEST['edit_item'] == $key): ?>
					<form action='<?=$server?>' method='post' name='edit_item_form' id='edit_item_form'>
						<input type="hidden" name="edit_item" id="edit_item" value="<?=htmlspecialchars($key)?>"></input>
						<td><input type="text" name="edit_item_txt" id="edit_item_txt" value="<?=htmlspecialchars($val)?>"></input></td>
						<td><input type="submit" value="SAVE" /></td>
					</form>
				<?php else: ?>
					<td><?=htmlspecialchars($val)?></td>
					<td><a href="<?=$script?>?edit_item=<?=htmlspecialchars($key)?>">EDIT ITEM</a></td>
				<?php endif;?>
				<td><a href="<?=$script?>?delete_item=<?=htmlspecialchars($key)?>">DELETE ITEM</a></td>
			</tr>
		<?php endforeach;?>
	</table>

	<form action='<?=$server?>' method='post' name='add_item_form' id='add_item_form'>
		<input type="hidden" name="add_item" id="add_item" value="1"></input>
		<input type="text" name="add_item_txt" id="add_item_txt" value=""></input>
		<input type="submit" value="SUBMIT" />
	</form>

	<a href="<?=$script?>?delete_all_items">DELETE ALL ITEMS</a>
	
</body>
</html>
