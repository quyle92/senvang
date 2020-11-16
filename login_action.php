<?php
require('lib/db.php');
session_start();
	$user=$_POST['username'];
	$pass=$_POST['password'];
	$remember=$_POST['remember'];	
	//Truy van DB de kiem tra
	$sql="select PWDCOMPARE('$pass',MatKhau) as IsDungMatKhau, TenSD, b.MaNV,b.TenNV, b.MaTrungTam, c.TenTrungTam  
from tblDSNguoiSD a, tblDMNhanVien b, tblDMTrungTam c where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD like '$user'";
	
	try
	{
		//lay ket qua query
		$result_dangnhap = sqlsrv_query($dbCon, $sql);
		if($result_dangnhap != false)
		{
			//show the results
				$r = sqlsrv_fetch_array($result_dangnhap);

				$_SESSION['TenSD']=$r['TenSD'];
				$_SESSION['MaNV']=$r['MaNV'];
				$_SESSION['TenNV']=$r['TenNV'];
				$_SESSION['MaTrungTam'] = $r['MaTrungTam'];
				$_SESSION['TenTrungTam']=$r['TenTrungTam'];
			
			//https://phppot.com/php/php-login-script-with-remember-me/
			if(!empty($_POST["remember"])) 
			{
				setcookie ("username",$user,time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("password",$pass,time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["member_login"])) {
					setcookie ("username","");
					setcookie ("password","");
				}
			}
			
			
			header('location:dophu.php');
		}
		else
		{
?>
		<script>
			window.onload=function(){
		alert("Đăng nhập không thành công. Sai email hoặc mật khẩu");
			setTimeout('window.location="login.php"',0);
		}
		</script>
<?php
		}
	}
	catch (PDOException $e) 
	{	
	//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
	