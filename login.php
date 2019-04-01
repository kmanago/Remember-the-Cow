<?php
session_start();

//change these for your own settings
$host = "localhost";
$dbname = "login";
$username = "root";
$password = "root";

//start connection and change values for your own as well
$mysqli = new mysqli("localhost", "root", "root", "login");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//grab username and password from start.php
$username = $_POST['name'];
$password = $_POST['password'];
$ucookie = date(DATE_RFC822); //still need to get the final format and this is just the user's cookie for once they signed in
//sets a cookie named Time that lasts 6 days
setcookie('Time', date("D y M d, g:i:s a"), time()+518400);
 
	//if the username and password fit the criteria then continue on
    if (preg_match('/^[a-z]+[a-z0-9]{3,8}$/', $username) && preg_match('/^[0-9]+[a-z0-9$@$!%*#?&()]+[$@$!%*#?&()]$/', $password))
	{
		//checks lenght of password as well and if incorrect go back to start
		if(strlen($password)<=5 || strlen($password)>=13){
			header("Location: start.php");
		}
		
	   else{
		    //checks if the username and password matches in the database for what was entered
		$querydata = "SELECT * FROM users WHERE username ='$username' AND password = '$password'";
        $sql = "SELECT id FROM users WHERE username ='$username'";
        $result = mysqli_query($mysqli,$sql);
        if($result != false){
            $id = mysqli_fetch_object($result);
            $_SESSION['id'] = $id->id;
        }
		$submission = mysqli_query($mysqli,$querydata);
			
		//sets the session name and passord if they exist
		if(mysqli_num_rows($submission)>0){	
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['cookie'] = $ucookie;
		}
		
	    	//adds user to the database and set up the session for them if they do not exist
		else{
			$mysqli = new mysqli('localhost', 'root', 'root', 'login');
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();//failed connection and quit
			}
			$sql = "INSERT INTO users(username,password) VALUES('$username','$password')";
			$mysqli->query($sql);
            $_SESSION['id'] = $id;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['cookie'] = $ucookie;
		}
		//takes them to the todolist
		header("Location: todolist.php");
	   }
	}
    //if the username or password does not fit the requirements then return them to start
    else {
		header("Location: start.php");
	}
        
?>
Contact GitHub API Training Shop Blog About
© 2017 GitHub, Inc. Term
