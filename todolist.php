<!DOCTYPE html>
<?php
   require_once 'start.php';
	
	//selects from the database
	$itemsQuery = $db->prepare("
		SELECT id, name, done
		FROM items
		WHERE user = :user
	");
	
	$itemsQuery -> execute([
		'user' => $_SESSION['id'];
	]);
	
	$items = $itemsQuery-> rowCount () ? $itemsQuery : [];
	
	foreach($items as items){
		print_r($item);
	}
    
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Remember the Cow</title>
		<link href="cow.css" type="text/css" rel="stylesheet" />
		<link href="favicon.ico" type="image/ico" rel="shortcut icon" />
	</head>

	<body>
		<div class="headfoot">
			<h1>
				<img src="logo.gif" alt="logo" />
				Remember<br />the Cow
			</h1>
		</div>

		<div id="main">

            <h2><?php echo $_SESSION['username'];?> To-Do List</h2>
			
			<?php if (!empty($items)): ?>
				<ul id="todolist">
				
				<?php
					foreach($items as $item): 	
				?>
					<li>
						<span class="item <php echo $item'done'] ? ' done' : ''?>"
						<?php echo $item['name']; ?></span>
						
						<?php if (!$item['done']): ?> <!--if an item isn't done delete it from the list -->
							<form id="delete-item" action="submit.php" method="post">
								<input type="submit" value="Delete" />
							</form>
						<?php endif; ?>
					</li>
					
					<?php
						endforeach; 	
					?>
					
					<li><!--add item to the list -->		
						<form id="add-item" action="submit.php" method="post">
							<div><input name="name" type="text" /><input type="submit" value="Add" /></div>
						</form>
					</li>
               </ul>
			<?php endif; ?>
			   
			<p>
			<!--log out-->
				<a href="logout.php"><b><u>Log Out</u></b></a> <em>(last login from this computer was ???)</em>
			</p>
		</div>

		<div class="headfoot">
			<p>
				<q>Remember The Cow is nice, but it's a total copy of another site.</q> - PCWorld<br />
				All pages and content &copy; Copyright CowPie Inc.
			</p>

		</div>
	</body>
</html>
