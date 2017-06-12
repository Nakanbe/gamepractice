<?php
	include("dbconnect.php");
  //include("\shared\db.php");
  header('Content-Type: application/json; charset=UTF-8');

  $conn = gamedb_conn();
  //抓網頁原始碼
  //$url = 'http://www.kufa88.com/Promotion/jingcai';
  //http://127.0.0.1/source4.html
  $url = 'http://www.kufa88.com/Promotion/jingcai';
  $line_array=file($url);
  $line_string=implode("", $line_array);
  $line_string =str_replace("\n", "", $line_string);
  
  //分析字串
  preg_match_all("/<table class=\"gameTable\">(.*?)<\/table>/", $line_string, $head);  //第一層
  //取日期
  preg_match_all("/<span class=\"moreIcon\"><\/span>(.*?) 每次/", $head[1][0], $date);
  
  $GameData = array();
  $colorarray = array();
  for($i = 1; $i <= count($date[1]); $i++){
    preg_match_all("/<tr class=\"moreContent more" . "$i" . ".*?row\">(.*?)<\/tr>/", $head[1][0], $tr);
    //key表示那一天的第幾場比賽
    foreach($tr[1] as $key => $value){
      //$GameData[$date[1][$i-1]][$key]['date'] = $date[1][$i-1];

      preg_match_all("/<span class=\"leagueName\".*?>(.*?)\s?<\/span>/", $value, $leagueName);  //leagueName
      $GameData[$date[1][$i-1]][$key]['leaguname'] = $leagueName[1][0];  //$GameData['2017-06-03'][0]['leagueName']

      preg_match_all("/<span class=\"ht\">(.*?)\s?<\/span>/", $value, $ht);  //ht
      $GameData[$date[1][$i-1]][$key]['ht'] = $ht[1][0];

      preg_match_all("/<span class=\"at\">(.*?)\s?<\/span>/", $value, $at);  //at
      $GameData[$date[1][$i-1]][$key]['at'] = $at[1][0];

      preg_match_all("/<td class=\"time\">(.*?)\s?<\/td>/", $value, $time);  //time
      $GameData[$date[1][$i-1]][$key]['time'] = $time[1][0] . ":00";

      preg_match_all("/<span>(.*?)\s+?<input.*?>/", $value, $odds);  //odds
      preg_match_all("/<span class=\"rq.*?>\+?([^\+].*?)\s?<\/span>/", $value, $rq); //rq1 + rq2
      
      //分析特別資料
      if(count($odds[1]) == 4){  //odds只有四筆資料
        //分析缺少那些資料
        $line_string3 = implode("", $odds[1]);  
        preg_match_all("/(.*?)\s+\d+.\d+/", $line_string3, $word);
        if($word[1][0] == "胜" && $word[1][1] == "负" && $word[1][2] == "胜" && $word[1][3] == "负"){
          $analyGame = "basketball1";
        }
        else if($word[1][0] == "胜" && $word[1][1] == "负" && $word[1][2] == "大" && $word[1][3] == "小"){
          $analyGame = "basketball2";
        }

        //籃球缺後面的資料 所以rq[1][2] and odds[1][4] and odds[1][5] 沒有資料 缺大小
        if($analyGame == "basketball1"){
          $rq[1][2] = "null";
          $odds[1][4] = "";
          $odds[1][5] = "";
        }

        //籃球缺中間的資料 所以rq[1][1] and odds[1][2] and odds[1][3] 沒有資料 缺勝負
        else if($analyGame == "basketball2"){
          //
          $rq[1][2] = $rq[1][1];
          $rq[1][1] = "null";
          for($j = 2; $j <= 3; $j++){
            $odds[1][$j+2] = $odds[1][$j];
            $odds[1][$j] = "";
          }
        }
      }
      
      //足球缺前面的資料 所以rq[1][0] and odds[1][0] and odds[1][1] and odds[1][2] 沒有資料
      if(count($odds[1]) == 3){  //odds只有三筆資料 
        $rq[1][1] = $rq[1][0];
        $rq[1][0] = "null";
        for($j = 3; $j <= 5; $j++){
          $odds[1][$j] = "";
        }
      }
      
      //把處理好的資料放進陣列裡
      for($j = 0; $j < count($rq[1]); $j++){
        $rqstr = 'rq' . $j;
        $GameData[$date[1][$i-1]][$key][$rqstr] = $rq[1][$j];  //rq0, rq1
      }
      for($j = 0; $j < count($odds[1]); $j++){
        $oddsstr = 'odds' . $j;
        $GameData[$date[1][$i-1]][$key][$oddsstr] = $odds[1][$j];  //odds0 ,odds1, odds2, odds3, odds4, odds5 
      }

      preg_match_all("/<td class=\"num\".*?>([\d]+).*?<\/td>/", $value, $num); //num
      $GameData[$date[1][$i-1]][$key]['num'] = $num[1][0];

      //preg_match_all("/<td><span class=\"leagueName\" style='background-color: (.*?);/", $value, $color);
      //$colorarray[$leagueName[1][0]] = $color[1][0];
      //<td><span class="leagueName" style='background-color: #22C126; color: #ffffff'>J2联赛</span></td>
    }
  }

  //有兩筆資料，分別為GAMEDATA和COLOR
  //Gamedata['2017-06-03'][0]['leaguename']
  //colorarray['J2联赛']
  //需要post的資料為 新增那些資料 更新那些資料 還有COLORARRAY(可先不用)
  //新增資料 = $newGamestr   更新資料 = $newGamestr
  //字串 = "2017-06-11,J2联赛,不死鸟,町田泽维,14:00,0,-1,胜 2.13,平 3.12,负 2.95,胜 4.80,平 3.70,负 1.54,0;
  //        2017-06-11,J2联赛,不死鸟,町田泽维,14:00,NULL,-1,胜 2.13,平 3.12,负 2.95,,,,0"

  $querystr = "INSERT INTO betgame (bet_date, bet_leaguname, bet_ht, bet_at, bet_time, bet_rq0, bet_rq1, bet_odds0, bet_odds1, bet_odds2, bet_odds3, bet_odds4, bet_odds5, bet_num) VALUES ";  //INSTERT string
  $flag = 0; //是否要INSERT
  $i = 0;
  $updateGameJSON = array();
  $insertGameJSON = array();
  foreach($GameData as $key => $value){ //$value為陣列，內容是$key這一天裡的所有比賽
    foreach($value as $key2 => $value2){ //哪場比賽 $value2為陣列，內容是一場比賽裡的所有資料
      //取出符合要求的資料，用來比較是否要更新資料，
      $queryselect = "SELECT 
                        bet_odds0 as odds0, 
                        bet_odds1 as odds1, 
                        bet_odds2 as odds2, 
                        bet_odds3 as odds3, 
                        bet_odds4 as odds4, 
                        bet_odds5 as odds5, 
                        bet_num as num, 
                        bet_ID                                           
                      FROM 
                        betgame 
                      WHERE 
                        bet_date = '" . $key . "' AND 
                        bet_leaguname = '" . $value2['leaguname'] . "' AND 
                        bet_ht = '" . $value2['ht'] . "' AND 
                        bet_at = '" . $value2['at'] . "' AND
                        bet_time = '" . $value2['time'] . "'";
      $result = gamedb_execute($queryselect,$conn); //執行SQL

      if($row = $result->fetch_array(MYSQLI_ASSOC)){ //當有找到資料時進行比對，沒有時進行INSERT
        if($row['odds0'] != $value2['odds0'] || $row['odds1'] != $value2['odds1'] || $row['odds2'] != $value2['odds2'] ||
           $row['odds3'] != $value2['odds3'] || $row['odds4'] != $value2['odds4'] ||
           $row['odds5'] != $value2['odds5'] || $row['num'] != $value2['num']){
          $queryupdate = "UPDATE 
                            betgame
                          SET
                            bet_odds0='" . $value2['odds0'] . "',
                            bet_odds1='" . $value2['odds1'] . "',
                            bet_odds2='" . $value2['odds2'] . "',
                            bet_odds3='" . $value2['odds3'] . "',
                            bet_odds4='" . $value2['odds4'] . "',
                            bet_odds5='" . $value2['odds5'] . "',
                            bet_num=" . $value2['num'] . "
                          WHERE
                            bet_ID=" . $row['bet_ID'];

        	// //JSON {"new": 
        	// 					[{"bet_date": 2017,
        	//						"bet_leaguname": ....},
        	// 					 {},
        	// 					 {}], 
        	// 				"update": 
        	// 				  [{},
        	// 				   {},
        	// 				   {}]}
        	$value2['date'] = $key;
        	array_push($updateGameJSON, $value2);

          gamedb_execute($queryupdate,$conn);//執行SQL
        }
      }
      else{

        //JSON
        $value2['date'] = $key;
        array_push($insertGameJSON, $value2);

        //組合要INSERT的資料
        $querystr .= "('" . $key . "','" . $value2['leaguname'] . "','" .
                                           $value2['ht'] . "','" .
                                           $value2['at'] . "','" .
                                           $value2['time'] . "'," .
                                           $value2['rq0'] . "," .
                                           $value2['rq1'] . ",'" .
                                           $value2['odds0'] . "','" .
                                           $value2['odds1'] . "','" .
                                           $value2['odds2'] . "','" .
                                           $value2['odds3'] . "','" .
                                           $value2['odds4'] . "','" .
                                           $value2['odds5'] . "'," .
                                           $value2['num'] . "),";
        $flag = 1; 
      }
    }
  }
  $querystr = substr($querystr,0,-1); //去除最後一個逗號
  if($flag == 1){
    gamedb_execute($querystr,$conn);//執行SQL
  }

  $analyGamestr = json_encode(array("new" => $insertGameJSON, "update" => $updateGameJSON));

  echo $analyGamestr;




?>



