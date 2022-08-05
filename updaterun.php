<?php include "connect.php";?>
<!DOCTYPE html>
<html>
	<head>
		<title>update_run</title>
	</head>
	<body>
<?php 
		//這段實際功能為修改資料(前端介面)
		//form action會將指定資料傳入所選的php中
        //以下submit用於更新?>
		<tr>
			Update &nbsp Datebase
			<br> &nbsp </br>
		</tr>
		<form action="" method="post">
            學號 &nbsp <input type="text" name="updatenumber"><br>
			姓名 &nbsp <input type="text" name="updatename"><br>
            科目 &nbsp <input type="text" name="updatesubject"><br>
            分數 &nbsp <input type="text" name="updatescore"><br>
			<input type="submit" name="update2button" value="更新">
        </form>
<?php
//這段的實際功能為修改資料(後端)
//將submit傳過來的表單匯入資料庫
$number = filter_input(INPUT_POST, "updatenumber");
$name = filter_input(INPUT_POST, "updatename");
$subject = filter_input(INPUT_POST, "updatesubject");
$score = filter_input(INPUT_POST, "updatescore");
//設定資料庫的帳號,密碼,伺服器和名稱並連線
$db_server = "localhost";
$db_name = "test";
$db_user = "root";
$db_passwd = "";
$db_connect = mysqli_connect($db_server, $db_user, $db_passwd, $db_name);
$db = mysqli_select_db($db_connect, 'test');
//isset 確認submit按鈕是否成功觸發
if(isset($_POST['update2button'])){
	//若任何一項輸入項目為空皆不會成功更新資料
	if(!empty($number)){
		if(!empty($name)){
			if(!empty($subject)){
				if(!empty($score)){
					$keynumber = $_POST['updatenumber'];
					//將填入的文字更新至所屬的keynumber(該筆資料即完成更新)
					$queryupdate = "UPDATE `students` SET name='$_POST[updatename]', subject='$_POST[updatesubject]', score='$_POST[updatescore]'" . "where number ='$keynumber' ";
					$queryupdate_run = mysqli_query($db_connect, $queryupdate);
					?>
					<?php 
					//1秒後前往所填的檔案或網址(秒數自訂)
					ob_start();
					header("Location: students.php");
					ob_end_flush();
				}else{
					echo '<script type="text/javascript"> alert("score should not empty!") </script>';
					die();
				}
			}else{
				echo '<script type="text/javascript"> alert("subject should not empty!") </script>';
				die();
			}
		}else{
			echo '<script type="text/javascript"> alert("name should not empty!") </script>';
			die();
		}
	}else{
		echo '<script type="text/javascript"> alert("number should not empty!") </script>';
		die();
	}
}
?>
</body>
</html>