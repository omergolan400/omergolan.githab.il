<?php
session_start();

if (!isset($_SESSION["user"])){
		header("location:index.php");
	}
	$user = $_SESSION["user"];
	$user_id = $_SESSION["user_id"];
	

	$MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=forum", "root", "");
	$MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$action = $_POST["action"];
	if (isset($_POST["data"])){
		$data = $_POST["data"];
		
	}
	header("Content-Type:application/json");
	switch($action){
		case "get_all_post";
				$cursor = $MySQLdb->prepare("SELECT * FROM posts");
				$cursor->execute();
				$retval=" ";
				
				
				foreach ($cursor->fetchALL()as $row){
					if ($row["user_id"] == $user_id){
						$retval = $retval . "<div class='media'><div class='media-body text-right' ><h4 class='media-heading'>".$user."</h4><p>".$row['post_data']."</p></div> <div class='media-right'><img src='assets/img/profile.jpg' class='media-object' style='width:60px'></div></div>";
						
						
					}else{
							$retval = $retval . "<div class= 'media '><div class='media-left'><img src='assets/img/profile.jpg' class='media-object' style='width:60px'></div><div class='media-body'><h4 class='media-heading'>".$row['username']."</h4><p>".$row['post_data']."</p></div></div>";
					}
					
					
					
				}
				echo '{"success":"true","data":"'.$retval.'"}';
				die();
					
			
			break;
		
		case "new_post";
			$cursor = $MySQLdb->prepare("INSERT INTO posts (user_id,post_data,username) value (:id,:data,:username)");
			$cursor->execute(array(":id"=>$user_id,":data"=>$data ,":username"=>$user));
			echo '{"success":"true"}';
			break;

		
		case "logout":
			session_destroy();
			//header("location:index.php");
			echo '{"success":"true"}';
			break;
		
		
		    default:
			echo '{"success":"false"}';
			die();
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>
   