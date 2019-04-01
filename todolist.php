
<!DOCTYPE html>
<?php
	session_start();
	
	$db = new PDO('mysql:dbname=users;host=localhost','root','');
	
	//selects from the database
	$itemsQuery = $db->prepare("
		SELECT todolist.id, item
		FROM todolist JOIN users ON users.id = todolist.id
		WHERE username = :username
	");
	
	$itemsQuery -> execute([
		'username' => $_SESSION['username']
	]);
	
	$items = $itemsQuery-> rowCount() ? $itemsQuery : [];
	
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Remember the Cow</title>
		<link href="cow.css" type="text/css" rel="stylesheet" />
		<link href="favicon.ico" type="image/ico" rel="shortcut icon" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
			<ul id="todolist">
                
			<?php if (!empty($items)): ?>		
				<?php
					foreach($items as $item): 
				    $object = trim($item['item']);
				?>
					<li id="<?php echo htmlspecialchars($object); ?>">
                        <?php //echo $item['item'];
                            $object = trim($item['item']);
                        ?>
                        <form action="submit2.php" method="post">
                            <?php echo "<input name='delete' type='text' value='$object''>"?>
                            <input id = "listitem" type=submit value="Delete"/>
                        </form>

					</li>
					
					<?php
						endforeach; 	
					?>
				   
			<?php endif; ?>
			   <li><!--add item to the list -->		
						<form id="add-item" action="submit2.php" method="post">
							<div><input name="name" type="text" value=""/><input type="submit" value="Add" /></div>
						</form>
				</li>
                </ul>
			<p>
			<!--log out-->
				<a href="logout.php"><b><u>Log Out</u></b></a> <em>(logged in since <?php echo $_SESSION['cookie']; ?>)</em>
			</p>
		</div>

		<div class="headfoot">
			<p>
				<q>Remember The Cow is nice, but it's a total copy of another site.</q> - PCWorld<br />
				All pages and content &copy; Copyright CowPie Inc.
			</p>

		</div>
	</body>
    <script>
        
        $("#listitem").click(function(){
           $(this).parent().parent().remove(); 
        });
    </script>
</html>