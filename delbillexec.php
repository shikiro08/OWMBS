<?php
include 'db.php';
	$id = $_POST['id'];
	mysqli_query($conn,"DELETE from billing WHERE id='$id'");
			

		 echo "<script>windows: location='viewbill.php'</script>";				
			