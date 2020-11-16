	
<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSpa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý nhà hàng ZinRes">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Custom Theme files -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!--fonts-->
 <link href="//fonts.googleapis.com/css?family=Cabin:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
 <link href="images/favicon-zintech.png" rel='icon' type='image/x-icon' />	
<!--//fonts--> 
</head>
<body>
<!-- login -->
	<h1 class="wthree">TRANG WEB THEO DÕI BÁN HÀNG DÀNH CHO CHỦ SPA</h1>
	<div class="container login-section">
	<div class="login-w3l">	
				<div class="login-form">			
					<form action="login_action.php" method="post">
						<div class="w3ls-icon">
							<i class="fa fa-user" aria-hidden="true"></i>
							<input type="text" class="user" name="username" placeholder="Tên đăng nhập" required value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>"/>
						</div>
						<div class="w3ls-icon">
							<i class="fa fa-unlock" aria-hidden="true"></i>
							<input type="password" class="lock" name="password" placeholder="Mật khẩu" required value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["password"]; } ?>"/>
						</div>
						<div class="signin-rit">
							<span class="checkbox1">
								<label class="checkbox"><input type="checkbox" name="remember" checked>Lưu mật khẩu</label>
							</span>
						<div class="clear"> </div>
						</div>
						<input type="submit" value="Đăng nhập">
					</form>	

				</div>
	<!-- //login -->
		</div>	
		<div class="login-w3l-bg">	
			<img src="images/phan-mem-nha-hang.jpg" alt=""/>
		</div>	
         
		<div class="clear"></div>	
	</div> 	
    <div class="footer">
		<p class="title">CÔNG TY TNHH GIẢI PHÁP CÔNG NGHỆ ZINTECH</h2>
        <p>Phone:02839310042 - Hotline:0966885959</p>
        <p>Website:www.zintech.vn</p>
        <p>Email:sales@zintech.vn</p>
        </br>
     </div>
        
        
	<div class="clearfix"></div>
		<!--//login-->
</body>
</html>