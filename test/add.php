<?php 
		//這段實際功能為新增資料(前端介面)
		//form action會將指定資料傳入所選的php中
        //以下submit用於新增?>
		<form action="students.php" method="post">
            學號 &nbsp <input type="text" name="testnumber" placeholder="Please Enter Number"><br>
			姓名 &nbsp <input type="text" name="testname" placeholder="Please Enter Name"><br>
            科目 &nbsp <input type="text" name="testsubject" placeholder="Please Enter Subject"><br>
            分數 &nbsp <input type="text" name="testscore" placeholder="Please Enter Score"><br>
			<input type="submit" name="addbutton" value="新增">
        </form>
		
<?php
//這段實際功能為新增資料(後端)
//將submit傳過來的表單匯入資料庫
$number = filter_input(INPUT_POST, "testnumber");
$name = filter_input(INPUT_POST, "testname");
$subject = filter_input(INPUT_POST, "testsubject");
$score = filter_input(INPUT_POST, "testscore");
//設定資料庫的帳號,密碼,伺服器和名稱
$db_server = "localhost";
$db_name = "test";
$db_user = "root";
$db_passwd = "";
$db = new mysqli($db_server, $db_user, $db_passwd, $db_name);
//設定資料庫用的語法為utf8
mysqli_set_charset($db,'utf8');
if(isset($_POST['addbutton'])){
	//若任何一項輸入項目為空皆不會成功新增資料
	if(!empty($number)){
		if(!empty($name)){
			if(!empty($subject)){
				if(!empty($score)){
					//新增所獲得的值(內容)進入所對應的資料庫項目
					$sql = "INSERT INTO students(number, name, subject, score) values('$number', '$name', '$subject', '$score')";
					if($db->query($sql)){
						echo '<script type="text/javascript"> alert("Data Add Success") </script>';
						header("refresh:0.1 ; students.php");
					}else{
						echo "Error: ".$sql."<br>".$db->error;
					}
					//關閉資料庫
					$db->close();
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