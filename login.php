<?php include "connect.php";?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<?php
		$loginquery = mysqli_query($db, "select * from login") or die("could not fetch".mysqli_error());
		?>
		<?php 
		//這段實際功能為登入帳號(介面)
		//form action會將指定資料傳入所選的php中
        //以下submit用於登入?>
		<tr>
			<td>Login</td>
			<br> &nbsp </br>
		</tr>
		<form action="login.php" method="post">
            帳號：<input type="text" name="usernametext"><br>
			密碼：<input type="password" name="passwordtext"><br>
			<input type="submit" name="loginbutton" value="登入">
        </form>
		
		<?php
			//將資料庫的內容拿出,並將其依序列印
			while ($row = mysqli_fetch_array($loginquery)){?>
			<tr>
				<form action="login.php" method="post" role="form">
				
					<?php //給他該資料庫帳密的內容 ?>
					<?php $usernamekey = $row["username"];?>
					<?php $passwordkey = $row["password"];?>
				</form>
			</tr>
			<?php  }
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
						die();
					}
				}else{
					echo '<script type="text/javascript"> alert("username error Login Fail !") </script>';
					die();
				}
			}
		?>
	</body>
</html>