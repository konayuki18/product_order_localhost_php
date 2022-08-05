<?php include "connect.php";?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
	<?php
	$loginquery = mysqli_query($db, "select * from login") or die("could not fetch".mysqli_error());
	?>

	<?php
		//將資料庫的內容拿出,並將其依序列印
		while ($row = mysqli_fetch_array($loginquery)){?>
		<tr>
			<form action=" " method="post" role="form">
				<?php //給他該資料庫帳密的內容 ?>
				<?php $usernamekey = $row["username"];?>
				<?php $passwordkey = $row["password"];?>
			</form>
		</tr>
		<?php	}
		?>
	<?php
		//這段實際功能為登入帳號(後端)
		//將表單接收的資料取得並定義新的變數($usernameinput, $passwordinput)
		$usernameinput = filter_input(INPUT_POST, "usernametext");
		$passwordinput = filter_input(INPUT_POST, "passwordtext");
		//判斷帳號密碼是否一致,成功的話便會跳轉至資料庫的頁面
		if(isset($_POST['loginbutton'])){
			if($usernameinput === $usernamekey){
				if($passwordinput === $passwordkey){
					ob_start();
					header("Location: students.php");
					ob_end_flush();
				}else{
					echo '<script type="text/javascript"> alert("password error Login Fail !") </script>';
					ob_start();
					header("refresh:0 ;login.html");
					ob_end_flush();
				}
			}else{
				echo '<script type="text/javascript"> alert("username error Login Fail !") </script>';
				ob_start();
				header("refresh:0 ; login.html");
				ob_end_flush();
			}
		}
	?>
	</body>
</html>