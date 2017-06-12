<?php
	// $newGamestr = $_POST['analynewGame'];
	// $updateGamestr = $_POST['analyupdateGame'];
	//分析字串並存到陣列
	//newGame_arr 存 $newGamestr | updateGame_arr 存 $updateGamestr

	// $newGame_arr = array();
	// $updateGame_arr = array();
	// $searchGame_arr = array();
	// $result = array();
	// $todaydate = date('Y-m-d');
	//echo $_SERVER['HTTP_REFERER']; //http://127.0.0.1/game/gameanaly.php?

	// if(isset($_POST['analynewGame']) || isset($_POST['analyupdateGame'])){
	// 	$newGamestr = $_POST['analynewGame'];
	// 	$newGame_arr = analyPostString($newGamestr, 'new');
	// 	$updateGamestr = $_POST['analyupdateGame'];
	// 	$updateGame_arr = analyPostString($updateGamestr, 'update');
	// 	$result = array_merge($newGame_arr, $updateGame_arr);
	// }
	// if(isset($_POST['searchGame'])){

	// 	$searchGamestr = $_POST['searchGame'];
	// 	$searchGame_arr = analyPostString($searchGamestr, 'date');
	// 	$result = $searchGame_arr;
	// }

	// if(isset($_POST['analynewGame'])){
	// 	$newGamestr = $_POST['analynewGame'];
	// 	$newGame_arr = analyPostString($newGamestr, 'new');
	// }
	// if(isset($_POST['analyupdateGame'])){
	// 	$updateGamestr = $_POST['analyupdateGame'];
	// 	$updateGame_arr = analyPostString($updateGamestr, 'update');
	// }

	

 //  $colorarray = array('世青赛' => '#C58788',
 //                    '世界杯预' => '#336600',
 //                    '阿根廷杯' => '#336699',
 //                    '国际赛' => '#327E7C',
 //                    '巴西甲' => '#336699',
 //                    '韩足总杯' => '#354896',
 //                    'J2联赛' => '#22C126',
 //                    '亚冠' => '#336699',
 //                    '欧冠' => '#F75000',
 //                    '南俱杯' => '#888700',
 //                    '日联杯' => '#08855C',
 //                    '英超' => '#FF3333',
 //                    '解放者杯' => '#00A653',
 //                    '美职' => '#7D3052',
 //                    '南优胜杯' => '#c5aa44',
 //                    '巴西杯' => '#006633');
	// //output
	// $outputstr = "<table class='gametable'>
 //                  <thead>
 //                    <tr>
 //                      <th width='100'>賽事</th>
 //                      <th width='200'>&nbsp;&nbsp;主隊&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;客隊&nbsp;&nbsp;</th>
 //                      <th width='80'>截止</th>
 //                      <th>讓球</th>
 //                      <th width='300'>主勝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;平局&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客勝</th>
 //                      <th width='150'>競猜人數</th>
 //                    </tr>
 //                  </thead>
 //                  <tbody>";
 //  $status = '';  //狀態，有date, update, new
 //  $change = 1;
 //  // $values[$idx][];
 //  foreach($result as $statuskey => $values){
 //    //leaguname, ht, at, time, rq1, rq2
 //    foreach($values as $output){
	//     if($statuskey != $status){ //狀態不一樣時就要加這些HTML
	//     	$status = $statuskey;
	//     	if($statuskey == 'new'){
	//     		$str = '新增';
	//     	}
	//     	else if($statuskey == 'update'){
	//     		$str = '更新';
	//     	} 
	//     	else{
	//     		$str = $statuskey . ' 每次竞猜选择一个选项下注';
	//     	}
	//       $outputstr .=
	//         '<tr class="more expanded" id="more'."$change".'" style="border-top: 0;" onclick="r('."$change".');">
	//           <td colspan="6"><span class="moreIcon"></span>' . $str . ' </td>
	//         </tr>';
	//         $change++;
	//     }
	//     $outputstr .= 
	//       '<tr class="moreContent more' . ($change-1) . '">'.
	//         '<td><span class="leaguname" style="background-color:' . $colorarray[$output['bet_leaguname']] . '; color: #FFFFFF">';
	//     if($statuskey == 'new'){ //新增要印出來新增的比賽日期
	//     	$outputstr .= $output['bet_leaguname'] . '</span><span>' . $output['bet_date'] . '</span> </td>';
	//     }
	//     else{
	//     	$outputstr .= $output['bet_leaguname'] . '</span> </td>';
	//     }
	//     $outputstr .=
	//         '<td><span class="vs"><span class="ht">' . $output['bet_ht'] . '</span>vs<span class="at">' . $output['bet_at'] . '</span></span></td>
	//         <td>' . substr($output['bet_time'], 0, 5) . '</td>';
	//     if($output['bet_rq1'] < 0){ //rq1 < 0 時為綠色
	//       $rqcolor = "green";
	//     }
	//     else{  //rq1 > 0 時為紅色
	//       $rqcolor = 'red';
	//       //$output['bet_rq1'] = '+' . $output['bet_rq1'];
	//     }
	//     if($output['bet_rq0'] == '' || $output['bet_rq0'] == 'NULL'){  //沒有資料就不印出來了
	//       $outputstr .= '<td><span class="rq2" style="color:'. $rqcolor .';">' . $output['bet_rq1'] . '</span></td>';
	//     }
	//     else{
	//       $outputstr .= '<td><span class="rq1">' . $output['bet_rq0'] . '</span><span class="rq2" style="color:'.    $rqcolor .';">' . $output['bet_rq1'] . '</span></td>';
	//     }
	//     if($output['bet_odds3'] == ""){ //沒有資料就不印出來了
	//       $outputstr .=
	//       '<td class="odds"><span>' . $output['bet_odds0'] . '</span>
	//                         <span>' . $output['bet_odds1'] . '</span>
	//                         <span>' . $output['bet_odds2'] . '</span></td>';
	//     }
	//     else{
	//       $outputstr .=
	//       '<td class="odds"><span>' . $output['bet_odds0'] . '</span>
	//                         <span>' . $output['bet_odds1'] . '</span>
	//                         <span>' . $output['bet_odds2'] . '</span>
	//                         <span>' . $output['bet_odds3'] . '</span>
	//                         <span>' . $output['bet_odds4'] . '</span>
	//                         <span>' . $output['bet_odds5'] . '</span></td>';
	//     }
	    
	//     $outputstr = $outputstr .'<td style="color:#ed3a37;">' . $output['bet_num'] . '人竞猜</td>
	//       </tr>';
	//   }
	// }
 //  $outputstr .= " </tbody></table>";

	// //分析POST的字串
	// function analyPostString($str, $status){
	// 	$returnarr = array();
	// 	//第一次先用';'把字串分解
	// 	$temparr = explode(';', $str);
	// 	//再用','分解 
	// 	for($i = 0; $i < count($temparr) - 1; $i++){ //-1是因為後面會多一個空值
	// 		$temparr2 = explode(',', $temparr[$i]);
	// 		if($status != 'new' && $status != 'update'){
	// 			$status = $temparr2[0] ;
	// 		}
	// 		$returnarr[$status][$i]['bet_date'] = $temparr2[0];
	// 		$returnarr[$status][$i]['bet_leaguname'] = $temparr2[1];
	// 		$returnarr[$status][$i]['bet_ht'] = $temparr2[2];
	// 		$returnarr[$status][$i]['bet_at'] = $temparr2[3];
	// 		$returnarr[$status][$i]['bet_time'] = $temparr2[4];
	// 		$returnarr[$status][$i]['bet_rq0'] = $temparr2[5];
	// 		$returnarr[$status][$i]['bet_rq1'] = $temparr2[6];
	// 		$returnarr[$status][$i]['bet_odds0'] = $temparr2[7];
	// 		$returnarr[$status][$i]['bet_odds1'] = $temparr2[8];
	// 		$returnarr[$status][$i]['bet_odds2'] = $temparr2[9];
	// 		$returnarr[$status][$i]['bet_odds3'] = $temparr2[10];
	// 		$returnarr[$status][$i]['bet_odds4'] = $temparr2[11];
	// 		$returnarr[$status][$i]['bet_odds5'] = $temparr2[12];
	// 		$returnarr[$status][$i]['bet_num'] = $temparr2[13];
	// 	}
	// 	return $returnarr;
	// }
?>