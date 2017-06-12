<?php
	include("dbconnect.php");
	header('Content-Type: application/json; charset=UTF-8');
  //include("\shared\db.php");

  $conn = gamedb_conn();


	//共有五個參數傳進來
	//$search_start_date, $search_end_date, $search_leaguname, $search_ht, $search_at
	$start_date = $_POST['search_start_date'];
	$end_date = $_POST['search_end_date'];
	$leaguname = $_POST['search_leaguname'];
	$ht = $_POST['search_ht'];
	$at = $_POST['search_at']; 

	$searchGame = '123';

	if(!empty($start_date) || !empty($end_date) || !empty($leaguname) || !empty($ht) || !empty($at)){
		//SELECT * FROM betgame WHERE bet_date='2017-06-03' AND bet_leaguename = '123456' AND 
		$tarr = array(); //把資料先放進陣列，之後再合併
		if($start_date != '' && $end_date != ''){ //當兩個都是空的時候，抓兩個之間的比賽
			$tarr[1] = 'bet_date>="' . $start_date . '"';
			$tarr[2] = 'bet_date<="' . $end_date . '"';
		}
		else if($start_date == '' && $end_date != ''){   //其中一個沒有值的時候，就抓有值的那個的資料
			$tarr[1] = 'bet_date="' . $end_date . '"';
		}
		else if($end_date == '' && $start_date != ''){
			$tarr[1] = 'bet_date="' . $start_date . '"';
		}
		if($leaguname != ''){
			$tarr[3] = 'bet_leaguname="' . $leaguname . '"';
		}
		if($ht != ''){
			$tarr[4] = 'bet_ht="' . $ht . '"';
		}
		if($at != ''){
			$tarr[5] = 'bet_at="' . $at . '"';
		}
		//$search_query = chop($search_query," AND "); //去掉最後的逗號
		$str = implode($tarr, ' AND ');
		$search_query = "SELECT bet_date, bet_leaguname, bet_ht, bet_at, bet_time, bet_rq0, bet_rq1, bet_odds0, bet_odds1, bet_odds2, bet_odds3, bet_odds4, bet_odds5, bet_num FROM betgame WHERE " . $str;
		//echo $search_query;
		
		/*$search_query = "SELECT bet_date, bet_leaguname, bet_ht, bet_at, bet_time, bet_rq0, bet_rq1, bet_odds0, bet_odds1, bet_odds2, bet_odds3, bet_odds4, bet_odds5, bet_num FROM betgame WHERE bet_date='2017-06-10'";*/
		//echo $search_query;

		$result = gamedb_execute($search_query, $conn);
		$i = 0;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$arr1[$i] = $row;
			$i++;
		}
		$searchGame = json_encode(array("date" => $arr1));
		// $searchGame = json_encode($arr1);
	}
	// 	while($row = $result->fetch_array(MYSQLI_NUM)){ //第一次合併，每個比賽的資料合併，所以要加,
	// 		$arr1[$i] = implode(',', $row);
	// 		$i++;
	// 	}
	// 	for($j = 0; $j < $i; $j++){  //第二次合併，所有字串合併，所以加;號
	// 		$searchGame = implode(';', $arr1);
	// 	}
	// }

	// if($searchGame != ''){
	// 	$searchGame .= ';'; //最後要加一個;號，為了使資料一致
	// }

	echo $searchGame;

// 	<!DOCTYPE HTML>
// <html>
// <head>
// 	<meta charset="UTF-8">
// </head>
// <body>
// 	<form action="index.php" method="post" id="searchform">
// 		<input type="hidden" name="searchGame" value="<?php echo $searchGame; >"></input>
// </form>
// </body>
// </html>

// <script>
// 	document.getElementById('searchform').submit();  //submit form
// </script> 
?>

