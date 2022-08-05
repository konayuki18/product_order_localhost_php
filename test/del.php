<?php include "connect.php";?>
<!DOCTYPE html>
<html>
<head>
    <title>del</title>
	<link rel="stylesheet type="text/css" href="css/bootstrap.min.css"> <!--for styling-->
</head>
<body style="padding-top: 100px;">

<?php
	$fetchQuery = mysqli_query($db, "select * from students") or die("could not fetch".mysqli_error());
?>
    <div class="container">
	
	    <table class="table table-condensed table-bordered">
		    <tr>
				<td>number &nbsp</td>
				<td>name &nbsp &nbsp &nbsp</td>
				<td>subject &nbsp &nbsp</td>
				<td>score &nbsp</td>
				<td>Select &nbsp</td>
				<td>Delete &nbsp</td>
			</tr>
			<?php
			while ($row = mysqli_fetch_array($fetchQuery)){?>
			<tr>
				<form action="del.php" method="post" role="form">
				
					<td><?php echo $row["number"];?></td>
					<td><?php echo $row["name"];?></td>
					<td><?php echo $row["subject"];?></td>
					<td><?php echo $row["score"];?></td>
					<td>
						<input type="checkbox" name="keytodel" value="<?php echo $row['number'];?>" required>
					</td>
					<td>
						<input type="submit" name="delbutton" value="刪除">
					</td>
				
				</form>
			</tr>
			<?php  }
			?>
		</table>
	<?php
		if(isset($_POST['delbutton'])){
			$key = @$_POST['keytodel'];
			$check = mysqli_query($db, "select * from students where number = '$key'") or die("not found".mysqli_error());
			if(mysqli_num_rows($check)>0){
				//means record fround and delete it
				$querydel = mysqli_query($db, "DELETE FROM `students` where number ='$key'") or die("not delete".mysqli_error());?>
				<div>
					<p>Record deleted</p>
				</div>
			<?php 
				header("refresh:1 ; del.php");
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