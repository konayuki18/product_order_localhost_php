<?php include "connect.php";?>
<html>
	<head>
		<title>Search</title>
	</head>
	<body>
		<?php 
		//這段實際功能為搜尋(介面)
		//form action會將指定資料傳入所選的php中
        //以下submit用於搜尋?>
		<form action="search.php" method="post">
            <input type="text" name="searchtext" placeholder="Search here">
			<input type="submit" name="searchbutton" value="搜尋">
        </form>
		
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
							<form action="search.php" method="post" role="form">
				
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
					die();
				}
			}
		?>
	</body>
</html>