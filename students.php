<?php include "connect.php";?>
<!DOCTYPE html>
<html>
	<head>
		<title>TestStudent</title>
	</head>
	<body>
	
	<?php
		$fetchQuery = mysqli_query($db, "select * from students") or die("could not fetch".mysqli_error());
    ?>
	
    <div class="container">
	
		<?php 
		//這段實際功能為搜尋(介面)
		//form action會將指定資料傳入所選的php中
        //以下submit用於搜尋?>
		<form action="students.php" method="post">
            <input type="text" name="searchtext" placeholder="Search here">
			<input type="submit" name="searchbutton" value="搜尋">
        </form>
		
		<?php //資料庫列印的內容(前端介面)?>
	    <table class="table table-condensed table-bordered">
		    <tr>
				<?php //設定表頭 ?>
				<td>number &nbsp </td>
				<td>name &nbsp &nbsp &nbsp </td>
				<td>subject &nbsp &nbsp </td>
				<td>score &nbsp </td>
				<td>Select &nbsp </td>
				<td>Delete &nbsp </td>
				<td>Update &nbsp </td>
			</tr>
			<?php
			//資料庫列印內容(後端)
			//將資料庫的內容拿出,並將其依序列印
			while ($row = mysqli_fetch_array($fetchQuery)){?>
			<tr>
				<form action=" " method="post" role="form">
				
					<?php //給他該資料庫標籤的內容 ?>
					<td><?php echo $row["number"];?></td>
					<td><?php echo $row["name"];?></td>
					<td><?php echo $row["subject"];?></td>
					<td><?php echo $row["score"];?></td>
					<td>
						<?php //required 如果沒勾選就不能執行submit按鈕 ?>
						<input type="checkbox" name="checkkey" value="<?php echo $row['number'];?>" required>
					</td>
					<td>
						<?php //這段的實際功能為刪除資料(前端介面) ?>
						<input type="submit" name="delbutton" value="刪除">
					</td>
					<td>
						<?php //這段的實際功能為修改資料(前端介面) ?>
						<input type="submit" name="updatebutton" value="修改">
					</td>
				
				</form>
			</tr>
			<?php  }
			?>
		</table>
	</div>
	
	<?php
			//isset 確認submit按鈕是否成功觸發
			if(isset($_POST['searchbutton'])){
				$keyword = $_POST['searchtext'];
				$searchquery = mysqli_query($db, "select * from students where number='$keyword' OR name='$keyword' OR subject='$keyword' OR score='$keyword' ") or die("could not fetch".mysqli_error());
				$searchcount = mysqli_num_rows($searchquery);
				if($searchcount > 0){ ?>
					<table class="table table-condensed table-bordered">
						<?php //設定表頭 ?>
						<tr>
							<br> &nbsp </br>
							Search results
						</tr>
						<tr>
							<td>number &nbsp </td>
							<td>name &nbsp &nbsp &nbsp </td>
							<td>subject &nbsp &nbsp </td>
							<td>score &nbsp </td>
							<td>Select &nbsp </td>
							<td>Delete &nbsp </td>
							<td>Update &nbsp </td>
						</tr>
				
						<?php
						//將資料庫的內容拿出,並將其依序列印
						while ($row = mysqli_fetch_array($searchquery)){?>
						<tr>
							<form action="students.php" method="post" role="form">
				
								<?php //給他該資料庫標籤的內容 ?>
								<td><?php echo $row["number"];?></td>
								<td><?php echo $row["name"];?></td>
								<td><?php echo $row["subject"];?></td>
								<td><?php echo $row["score"];?></td>
								<td>
								<?php //required 如果沒勾選就不能執行submit按鈕 ?>
									<input type="checkbox" name="checkkey" value="<?php echo $row['number'];?>" required>
								</td>
								<td>
									<?php //這段的實際功能為刪除資料(前端) ?>
									<input type="submit" name="delbutton" value="刪除">
								</td>
								<td>
									<?php //這段的實際功能為修改資料(前端) ?>
									<input type="submit" name="updatebutton" value="修改">
								</td>
							
							</form>
						</tr>
						<?php
						}?>
						</table>
				<?php
				}else{
					echo '<script type="text/javascript"> alert("Not Found!") </script>';
				}
			}
	?>
		
	<?php
		//這段的實際功能為刪除資料(後端)
		//isset 確認submit按鈕是否成功觸發
		if(isset($_POST['delbutton'])){
			$key = @$_POST['checkkey'];
			$check = mysqli_query($db, "select * from students where number = '$key'") or die("not found".mysqli_error());
			//拿到"checkkey"的值(一定大於0,因為值都是給number),如果大於0就確認刪除該項目
			if(mysqli_num_rows($check)>0){
				//means record fround and delete it
				$querydel = mysqli_query($db, "DELETE FROM `students` where number ='$key'") or die("not delete".mysqli_error());
				echo '<script type="text/javascript"> alert("Delete Data Success!") </script>';?>
			<?php 
				//1秒後重新載入所填的檔案或網址(秒數自訂)
				header("refresh:0.1 ; students.php");
			}
			else{
				//give warning that recorf does exist?>
				<div>
					<p>Record does not exist</p>
				</div>
			<?php }
		}
		//這段的實際功能為修改資料(後端)
		//isset 確認submit按鈕是否成功觸發
		if(isset($_POST['updatebutton'])){
			$key = @$_POST['checkkey'];
			$check = mysqli_query($db, "select * from students where number = '$key'") or die("not found".mysqli_error());
			//拿到"checkkey"的值(一定大於0,因為值都是給number),如果大於0就確認修改該項目
			if(mysqli_num_rows($check)>0){
				//means record fround and delete it?>
			<?php 
				//1秒後前往所填的檔案或網址(秒數自訂)
				ob_start();
				header("Location: updaterun.php");
				ob_end_flush();
			}
			else{
				//give warning that recorf does exist?>
				<div>
					<p>Record does not exist</p>
				</div>
			<?php }
		}
	?>
	
		<?php 
			//這段實際功能為新增資料(前端)
			//form action會將指定資料傳入所選的php中
			//以下submit用於新增?>
		<tr> &nbsp </tr>
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

	</body>
</html>