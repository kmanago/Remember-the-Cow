<?php
    session_start();
	$db = new PDO('mysql:dbname=users;host=localhost','root','');

        $id = $_SESSION["id"];
//if you want to add
    if(isset($_POST["name"])){
        $name = $_POST['name'];
        $query = $db->prepare("INSERT INTO todolist(id,item)
        VALUES(:id,:item)
        ");
        
        $query->execute([
            'id'=>$id,
            'item'=>$name
        ]);
        
    }
       
//delete items
    else if(isset($_POST["delete"])){
        $deleteQuery = $db->prepare("DELETE FROM todolist 
        WHERE id = :id AND item = :item");
        
        $deleteQuery->execute([
            'id' => $id,
            'item' => trim($_POST["delete"])
        ]);
    }
       
    header("Location: todolist.php");

?>