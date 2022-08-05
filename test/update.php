<?php include "connect.php";?>
<!DOCTYPE html>
<html>
	<head>
		<title>update</title>
	</head>
	<body>
	
	<?php
		$fetchQuery = mysqli_query($db, "select * from students") or die("could not fetch".mysqli_error());
    ?>
	
    <div class="container">
	
	    <table class="table table-condensed table-bordered">
		    <tr>
				<?php //設定表頭 ?>
				<td>number &nbsp</td>
				<td>name &nbsp &nbsp &nbsp</td>
				<td>subject &nbsp &nbsp</td>
				<td>score &nbsp</td>
				<td>Select &nbsp</td>
				<td>Delete &nbsp</td>
				<td>Update &nbsp</td>
			</tr>
			<?php
			//將資料庫的內容拿出,並將其依序列印
			while ($row = mysqli_fetch_array($fetchQuery)){?>
			<tr>
				<form action="update.php" method="post" role="form">
				
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
			<?php  }
			?>
		</table>
		
	<?php
		//這段的實際功能為刪除資料(後端)
		//isset 確認submit按鈕是否成功觸發
		if(isset($_POST['delbutton'])){
			$key = @$_POST['checkkey'];
			$check = mysqli_query($db, "select * from students where number = '$key'") or die("not found".mysqli_error());
			//拿到"checkkey"的值(一定大於0,因為值都是給number),如果大於0就確認刪除該項目
			if(mysqli_num_rows($check)>0){
				//means record fround and delete it
				$querydel = mysqli_query($db, "DELETE FROM `students` where number ='$key'") or die("not delete".mysqli_error());?>
				<div>
					<p>Record deleted</p>
				</div>
			<?php 
				//1秒後重新載入所填的檔案或網址(秒數自訂)
				header("refresh:0.1 ; update.php");
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
	</div>
	</body>
</html>