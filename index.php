<?php

session_start();
	if(isset($_SESSION['user'])){
	header("Location:main.php");
	}

$MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=forum", "root", "");
$MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	if (isset($_POST['r_username']) && isset($_POST['r_password'])){
			$cursor = $MySQLdb->prepare("SELECT * FROM users  WHERE username=:username");
			$cursor->execute(array(":username"=>$_POST["r_username"]));
		
			if ($cursor->rowCount()){
				$msg =" username is already exist in db, please choose other username.";
				
			}else{
				 $cursor = $MySQLdb->prepare("INSERT INTO users (username, password) value (:username,:password)");
				 $cursor->execute(array(":username"=>$_POST["r_username"],":password"=>$_POST["r_password"]));
				// $msg =" registed Successfully";
			}
		
   }else    if(isset($_POST['l_username']) && isset($_POST['l_password'])){ 
		$cursor = $MySQLdb->prepare("SELECT * FROM users  WHERE username=:username AND password=:password");
		$cursor->execute(array(":username"=>$_POST["l_username"], ":password"=>$_POST["l_password"]));
		
		if($cursor->rowCount()){
			$return_value=$cursor->fetch();
			$_SESSION["user"]=$return_value["username"];
			$_SESSION["user_id"]=$return_value["id"];
			Header("Location:main.php");

			
		}else{
			$msg =" wrong username or password";
		}
		
		
	}
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login/Regsiter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h1>Forum</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Login

                </div>
                <div class="panel-body" id="login-panel">
                    <form action="index.php" method="POST">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="l_email" type="text" class="form-control" name="l_username" placeholder="username">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="l_password" type="password" class="form-control" name="l_password" placeholder="password">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">login</button>
                        <a href="#" id="register"><i class="glyphicon glyphicon-info-sign"></i>register</a>
						
						<?php
							if (isset($msg))
                            {
                                echo "<div class='alert alert-info'><strong>Error:</strong>".$msg."</div>";
                            }
						?>
                    </form>
                </div>
                <div class="panel-body" id="register-panel" hidden>
                    <form action="#" method="POST">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="r_username" type="text" class="form-control" name="r_username" placeholder="username">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="r_password" type="password" class="form-control" name="r_password" placeholder="password">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">register</button>
                        <a href="#" id="login"><i class="glyphicon glyphicon-info-sign"></i>login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#register").click(function () {
    $("#login-panel").fadeOut(1000);
    $("#register-panel").delay(1000).fadeIn(1000);
});
$("#login").click(function () {
    $("#register-panel").fadeOut(1000);
    $("#login-panel").delay(1000).fadeIn(1000);
});
</script>
</body>
</html>