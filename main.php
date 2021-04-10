<?php
session_start();
	if (!isset($_SESSION["user"])){
		header("Location:index.php");
	}
	$user = $_SESSION["user"];
	$user_id = $_SESSION["user_id"];
	
					
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">FORUM</a>
        </div>
        <ul class="nav navbar-nav" style="float: right">
            <li><a href="#" id="logout">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row" id="page" hidden>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Account Info</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <p>
                                <kbd>username:</kbd>
                                <span style="float:right;">
                                    <?php echo $user; ?>
                                </span>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <p>
                                <kbd>ip address</kbd>
                                <span style="float:right;">
                                    <?php echo $_SERVER["REMOTE_ADDR"];?>
                                </span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Chat History
                </div>
                <div class="panel-body">
                    <ul class="list-group" id="post_history">
						    <!-- Left-aligned -->
			<div class="media">
			  <div class="media-left">
				<img src="assets/img/profile.jpg" class="media-object" style="width:60px">
			  </div>
			  <div class="media-body">
				<h4 class="media-heading"></h4>
				<p></p>
			  </div>
			</div>

							<!-- Right-aligned -->
			<div class="media">
			  <div class="media-body text-right" >
				<h4 class="media-heading"></h4>
				<p></p>
			  </div>
			  <div class="media-right">
				<img src="assets/img/profile.jpg" class="media-object" style="width:60px">
			  </div>
			</div>
                        
                    </ul>
                </div>
            </div>
                <div class="input-group">
                    <input id="msg" type="text" class="form-control" name="msg" placeholder="Write your message here...">
                    <span class="input-group-addon"><button id="send_post">Send</button></span>
                </div>
        </div>
    </div>
</div>
<script>
	$("#page").slideDown("slow");
	
	$("#logout").click(function(){
		$.post("api.php",{"action":"logout"},function(data){
			if (data.success == "true"){
				 location.href = "index.php";
			}
		});
	});
	$("#send_post").click(function(){
		$.post("api.php",{"action":"new_post","data":$("#msg").val()},function(data){
			if (data.success == "true"){
				 location.reload();
			}
		});
	});
	
	$.post("api.php",{"action":"get_all_post"},function(data){
			if (data.success == "true"){
				$("#post_history").html(data.data);
		}
	});

</script>
</body>
</html>
