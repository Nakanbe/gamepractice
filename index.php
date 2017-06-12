

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="jingcai.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body style="background-color: #003f74;">
	<div class="content">
    <div>
      <div class="contentWrap">
      	<form id="searchform">
      	  <input type="date" name="search_start_date" >起</input>
      	  <input type="date" name="search_end_date">迄</input>
      	  <select name="search_leaguname">
      		<option value=""></option>
      		<option value="韩足总杯">韩足总杯</option>
					<option value="国际赛">国际赛</option>
					<option value="巴西甲">巴西甲</option>
					<option value="世界杯预">世界杯预</option>
					<option value="J2联赛">J2联赛</option>
					<option value="亚冠">亚冠</option>
					<option value="欧冠">欧冠</option>
					<option value="南俱杯">J2联赛</option>
					<option value="日联杯">日联杯</option>
					<option value="英超">英超</option>
					<option value="解放者杯">解放者杯</option>
					<option value="巴西杯">巴西杯</option>
      	  </select>
      	  主隊:<input type="text" name="search_ht"></input>
      	  客隊:<input type="text" name="search_at"></input>
      	  <input type="button" id="searchbtn" value="搜尋" onclick="searchGame();"></input>
        </form>
        <form action="gameanaly.php">
      	  <input type="button" id="analybtn" value="分析" onclick="analyGame();"></input>
        </form>
        <table class='gametable' id='gametable'>
					<thead>
						<tr>
							<th width='100'>賽事</th>
							<th width='200'>&nbsp;&nbsp;主隊&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;客隊&nbsp;&nbsp;</th>
							<th width='80'>截止</th>
							<th>讓球</th>
							<th width='300'>主勝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;平局&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客勝</th>
							<th width='150'>競猜人數</th>
						</tr>
					</thead>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

<script type="text/JavaScript">
	$(document).ready(function() {
		first();
	});
  function r(i) {
    const str = ".moreContent.more" + i;
    const idstr = "#more" + i;
    $(str).slideToggle(0);
    $(idstr).toggleClass("expanded");
  }

	function output(Gamedata){

		const color = { 世青赛: '#C58788',
                    世界杯预: '#336600',
                    阿根廷杯: '#336699',
                    国际赛: '#327E7C',
                    巴西甲: '#336699',
                    韩足总杯: '#354896',
                    J2联赛: '#22C126',
                    亚冠: '#336699',
                    欧冠: '#F75000',
                    南俱杯: '#888700',
                    日联杯: '#08855C',
                    英超: '#FF3333',
                    解放者杯: '#00A653',
                    美职: '#7D3052',
                    南优胜杯: '#c5aa44',
                    巴西杯: '#006633',
                    亚洲杯预: '#37BE5A',
                    美公开杯: '#B00900'};

		let gametable = "<thead><tr><th width='100'>賽事</th><th width='200'>&nbsp;&nbsp;主隊&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;客隊&nbsp;&nbsp;</th><th width='80'>截止</th><th>讓球</th><th width='300'>主勝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;平局&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客勝</th><th width='150'>競猜人數</th></tr></thead><tbody>";
		let i = 0, gamedate = "", change = 1, statuskey = "", str = "", rqcolor = "";
		for(key in Gamedata){
			for(i; i < Gamedata[key].length; i++){
				if(statuskey != key){
					statuskey = key;
					if(statuskey == "new"){
						str = "新增";
						gametable += '<tr class="more expanded" id="more' + change + '" style="border-top: 0;" onclick="r(' + change + ');"><td colspan="6"><span class="moreIcon"></span>' + str + ' </td></tr>'
					  change++;
					}
					else if(statuskey == "update"){
						str = "更新";
						gametable += '<tr class="more expanded" id="more' + change + '" style="border-top: 0;" onclick="r(' + change + ');"><td colspan="6"><span class="moreIcon"></span>' + str + ' </td></tr>'
						change++;
					}
				}
				if(gamedate != Gamedata[key][i]['date'] && key == "date"){
					str = Gamedata[key][i]['date'] + ' 每次竞猜选择一个选项下注';
					gamedate = Gamedata[key][i]['date'];
					gametable += '<tr class="more expanded" id="more' + change + '" style="border-top: 0;" onclick="r(' + change + ');"><td colspan="6"><span class="moreIcon"></span>' + str + ' </td></tr>'
					change++;
				}
				gametable += 
		      '<tr class="moreContent more' + (change-1) + '"><td><span class="leaguname" style="background-color:' + color[Gamedata[key][i]['leaguname']] + '; color: #FFFFFF">';
		    if(statuskey == 'new'){ //新增要印出來新增的比賽日期
		    	gametable += Gamedata[key][i]['leaguname'] + '</span><span>' + Gamedata[key][i]['date'] + '</span> </td>';
		    }
		    else{
		    	gametable += Gamedata[key][i]['leaguname'] + '</span> </td>';
		    }
		    gametable +=
		        '<td><span class="vs"><span class="ht">' + Gamedata[key][i]['ht'] + '</span>vs<span class="at">' + Gamedata[key][i]['at'] + '</span></span></td><td>' + Gamedata[key][i]['time'].substr(0, 5) + '</td>';
		    if(Gamedata[key][i]['rq1'] < 0){ //rq1 < 0 時為綠色
		      rqcolor = 'green';
		    }
		    else{  //rq1 > 0 時為紅色
		      rqcolor = 'red';
		      Gamedata[key][i]['rq1'] = '+' + Gamedata[key][i]['rq1'];
		    }
		    if(Gamedata[key][i]['rq0'] == '' || Gamedata[key][i]['rq0'] == 'null' || Gamedata[key][i]['rq0'] == null){  //沒有資料就不印出來了
		      gametable += '<td><span class="rq2" style="color:'+ rqcolor +';">' + Gamedata[key][i]['rq1'] + '</span></td>';
		    }
		    else{
		      gametable += '<td><span class="rq1">' + Gamedata[key][i]['rq0'] + '</span><span class="rq2" style="color:' + rqcolor + ';">' + Gamedata[key][i]['rq1'] + '</span></td>';
		    }
		    if(Gamedata[key][i]['odds3'] == null || Gamedata[key][i]['odds3'] == ''){ //沒有資料就不印出來了
		      gametable +=
		      '<td class="odds"><span>' + Gamedata[key][i]['odds0'] + '</span><span>' + Gamedata[key][i]['odds1'] + '</span><span>' + Gamedata[key][i]['odds2'] + '</span></td>';
		    }
		    else{
		      gametable +=
		      '<td class="odds"><span>' + Gamedata[key][i]['odds0'] + '</span><span>' + Gamedata[key][i]['odds1'] + '</span><span>' + Gamedata[key][i]['odds2'] + '</span><span>' + Gamedata[key][i]['odds3'] + '</span><span>' + Gamedata[key][i]['odds4'] + '</span><span>' + Gamedata[key][i]['odds5'] + '</span></td>';
		    }
		    
		    gametable += '<td style="color:#ed3a37;">' + Gamedata[key][i]['num'] + '人竞猜</td> </tr>';
		  }
		}
  gametable += " </tbody>";
  document.getElementById('gametable').innerHTML = gametable;
	}

	function first(){
		const d1 = new Date();
		let month = d1.getMonth()+1;
		let date = d1.getDate();
		if(month < 10){
			month = "0" + month;
		}
		if(date < 10){
			date = "0" + date;
		}
		let daystr = d1.getFullYear() + "-" + month + "-" + date;
		$.ajax({
  		type: "POST",
  		url: "http://127.0.0.1/game/gamesearch.php",
  		data: {
        search_start_date: daystr,
        search_end_date: '',
        search_leaguname: '',
        search_ht: '',
        search_at: ''
     	},
  		datatype: "JSON",
  		success: function(data){
  			output(data);
  		}
  	});
	}

	function searchGame(){
  	$.ajax({
  		type: "POST",
  		url: "http://127.0.0.1/game/gamesearch.php",
  		data: $("#searchform").serialize(),
  		datatype: "JSON",
  		success: function(data){
  			document.getElementById('gametable').innerHTML = "";
  			output(data);
  		}
  	});
	}

	function analyGame(){
		$.ajax({
	    type: "POST",
	    url: "http://127.0.0.1/game/gameanaly.php",
	    datatype: "JSON",
	    success: function(data) {
	    	document.getElementById('gametable').innerHTML = "";
        output(data);
	    }
	  });
	}
</script>