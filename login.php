<?php

session_start();

$username = $_POST['name'];
$password = $_POST['password'];

if($username && $password)
{
	//sets up a database connection
	$connect = mysql_connect("localhost", "root", "root") or die(
		"Couldn't connect. Error.");
	mysql_select_db("login") or die("Database could not be found.");
	
	$query = mysql_query("SELECT * FROM users WHERE username = '$username'");
	
	$rowNumber = mysql_num_rows($query);
	if($rowNumber != 0)
	{
		//grabs username and password from the database
		while($row = mysql_fetch_assoc($query))
		{
			$dbusername = $row['username'];
			$dbpassword = $row['password'];
		}
		
		//checks to see if the database and user match
		if($username == $dbusername && $password == $dbpassword)
		{
			$_SESSION['username'] = $dbusername;
			header("Location: todolist.php");
		}
		else
		{
			header("Location: start.php");
		}
		
	}
	else
	{
		//sets up database connection
		$connect = mysql_connect("localhost", "root", "root") or die(
		"Couldn't connect. Error.");
		mysql_select_db("login") or die("Database could not be found.");
		
		//sets up queries to add a user
		$query = mysql_query("INSERT INTO users(username, password) VALUES('$username', '$password')");
		$_SESSION['username'] = $username;
		header("Location: todolist.php");
	}
}
else if($username)
{
	//redirects if only username is provided
	header("Location: start.php");
}
else if($password)
{
	//redirects if only password is provided
	header("Location: start.php");
}
else
{
	die("You must enter a username and password.");
}

?>