<?php
	// include("dbconnect.php");
	// $str = "SELECT * FROM betgame WHERE bet_ID=152";
	// $conn = gamedb_conn();
	// $result = gamedb_execute($str,$conn);
	// $row = $result->fetch_array(MYSQLI_ASSOC);
	// print_r($row);


?>

<!DOCTYPE html>
<html>
<body>

<?php
$str = "SELECT * FROM betgame WHERE bet_date='2017-06-03' AND bet_leaguename = '123456' AND ";
echo $str;
echo chop($str," AND ");
?> 

</body>
</html>
