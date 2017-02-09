<?php

//Connect to Database
	$connect_ID=mysql_connect($_ENV['DATABASE_SERVER'], "db154870_colonel", "hUw7n{3!t_S");
	mysql_select_db("db154870_nyc_mos_noise") or die ("Could not connect to database");

?>

<html>
	<head>
		<title>noise city</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<meta name="apple-mobile-web-app-capable" content="yes" /> 
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<link rel="apple-touch-icon-precomposed" href="icon.png">
		<link rel="apple-touch-startup-image" href="startup.png">
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
        <script type="text/javascript" src="js/audiosprite.js"></script>
		<link type="text/css" rel="stylesheet" href="css/style.css"/>
<!-- 
		<link rel="stylesheet" href="css/add2home.css">
		<script type="application/javascript" src="js/add2home.js"></script>
 -->
        <script type="text/javascript" charset="utf-8">

		var t = 10000;
		var mm = 2;
		var pt = 4000;
		setInterval(nIncrement,1000);

		$(document).ready(function () { 
            $("#btnInit").click(initiate_watchlocation);  
            $("#btnStop").click(stop_watchlocation);  
        });  
  
			navigator.geolocation.getCurrentPosition(
				gotPosition,
				errorGettingPosition,
				{'enableHighAccuracy':true,'timeout':20000,'maximumAge':0}
			);

			var watchProcess = null;  

			function initiate_watchlocation() {
			    if (watchProcess == null) {
			        watchProcess = navigator.geolocation.watchPosition(handle_geolocation_query, errorGettingPosition, {enableHighAccuracy:true, maximumAge:3000, timeout:27000});
					$('#btnInit').hide();
					$('#btnStop').show();

			    } 
			}
	
			function stop_watchlocation() {
			    if (watchProcess != null)
			    {
			        navigator.geolocation.clearWatch(watchProcess);
			        watchProcess = null;
					clearTimeout(t);
					$('#btnInit').show();
					$('#btnStop').hide();
			    }
			}

			function alertTm()
			{
				$('#circled').fadeOut('slow',0);
				var arrkw = ['KEEP WALKING', 'You cannot just stand there.', 'Stay Calm. MOVE ON.', 'Be a good sport, KEEP IT DOWN.'];
				var randkw = arrkw[Math.floor(Math.random() * arrkw.length)];
				$("#msgs").html(randkw);
			}

			function handle_geolocation_query(position) {
				if (mm <= 0) {
					handle_audio_query(position);
					
				}
			}

			function nIncrement() {	mm--; }

			function playpl(timeP,responseDesc,responseLtype,responseIncd,responseCnt) {
				player.play(timeP);
				$('#SqlStatus').show().html(responseDesc+'<br/>'+responseLtype+' at '+responseIncd);

			}

			function handle_audio_query(position) {

			    var text = "You are within "  + Math.round(position.coords.accuracy)  + "m of the . . . <br/>";
				text = "";
   				$("#Output").html(text);
				$("#msgs").html('');
				$('#SqlStatus').show().html('scanning...');
				$.ajax({
					type: 'POST',
					url: 'fetch_noise.php',
					data: 'get_noise=nyc&lat='+position.coords.latitude+'&lng='+position.coords.longitude+'&accuracy='+position.coords.accuracy,
					cache: false,
					success: function(response){

						clearTimeout(t);
						t = setTimeout("alertTm()",20000);
						response = unescape(response);
						var response = response.split("|");
						var responseType = response[0];
						var aresponseLtype = jQuery.parseJSON(response[1]);
						var aresponseDesc = jQuery.parseJSON(response[2]);
						var aresponseIncd = jQuery.parseJSON(response[3]);
						var responseCnt = response[4];
						var responseLtype = '';
						var responseDesc = '';
						var responseIncd = '';
						var px = 0;
						if(responseType=="success"){
							// for(var i = responseCnt; i>0; i--) {

							mm = 3;
							//	px++;

								responseLtype = aresponseLtype[0];
								responseDesc = aresponseDesc[0];
								responseIncd = aresponseIncd[0];

								// $('#SqlStatus').show().html(responseDesc+'<br/>'+responseLtype+' at '+responseIncd);
								$('#SqlStatus').show().html(responseLtype+'<br/>at '+responseIncd);

							if(responseDesc=="Loud Music/Party"){
								var arrsn = ['0.01', '3', '6'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var ca = setTimeout(playpl(0.01,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
							} else 
							if(responseDesc=="Loud Talking"){
								var arrsn = ['9', '12', '15'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cb = setTimeout(playpl(1.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(1.0);
							} else
							if(responseDesc=="Car/Truck Music"){
								var arrsn = ['18', '21', '24'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cc = setTimeout(playpl(2.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(2.0);
							} else 
							if(responseDesc=="Noise: Construction Before/After Hours (NM1)"){
								var arrsn = ['27', '30', '33'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cd = setTimeout(playpl(3.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(3.0);
							} else 
							if(responseDesc=="Noise, Barking Dog (NR5)"){
								var arrsn = ['36', '39', '42'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var ce = setTimeout(playpl(4.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(4.0);
							} else 
							if(responseDesc=="Noise: Construction Equipment (NC1)"){
								var arrsn = ['45', '48', '51'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cf = setTimeout(playpl(5.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// $('#sndStatus').show().html('(5)');
							} else 
							if(responseDesc=="People Created Noise"){
								var arrsn = ['54', '57', '60'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cd = setTimeout(playpl(6.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(6.0);
								// $('#sndStatus').show().html('(6)');
							} else 
							if(responseDesc=="Noise: Jack Hammering (NC2)"){
								var arrsn = ['63', '66', '69'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// player.play(rsn);
								// var ce = setTimeout(playpl(7.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(7.0);
								// $('#sndStatus').show().html('(7)');
							} else 
							if(responseDesc=="Engine Idling"){
								var arrsn = ['72', '75', '78'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cf = setTimeout(playpl(7.9,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(8.0);
								// $('#sndStatus').show().html('(8)');
							} else 
							if(responseDesc=="Noise: Air Condition/Ventilation Equip, Commercial (NJ2)"){
								var arrsn = ['81', '84', '87'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cg = setTimeout(playpl(9.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(9.0);
								// $('#sndStatus').show().html('(9)');
							} else 
							if(responseDesc=="Manhole Cover Broken/Making Noise (SB)"){
								var arrsn = ['90', '93', '96'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var ch = setTimeout(playpl(10.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(10.0);
								// $('#sndStatus').show().html('(10)');
							} else 
							if(responseDesc=="Car/Truck Horn"){
								var arrsn = ['99', '102', '105'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var ci = setTimeout(playpl(11.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(11.0);
								// $('#sndStatus').show().html('(11)');
							} else 
							if(responseDesc=="Noise: Air Condition/Ventilation Equip, Residential (NJ1)"){
								var arrsn = ['108', '111', '114'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cj = setTimeout(playpl(12.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(12.0);
								// $('#sndStatus').show().html('(12)');
							} else 
							if(responseDesc=="Noise, Ice Cream Truck (NR4)"){
								var arrsn = ['117', '120', '123'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var ck = etTimeout(playpl(13.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(13.0);
								// $('#sndStatus').show().html('(13)');
							} else 
							if(responseDesc=="Noise: Alarms (NR3)"){
								var arrsn = ['126', '129', '132'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cl = setTimeout(playpl(14.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(14.0);
								// $('#sndStatus').show().html('(14)');
							} else 
							if(responseDesc=="Banging/Pounding"){
								var arrsn = ['135', '138', '141'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cm = setTimeout(playpl(15.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(15.0);
								// $('#sndStatus').show().html('(15)');
							} else 
							if(responseDesc=="Noise: Other Noise Sources (Use Comments) (NZZ)"){
								var arrsn = ['144', '147', '150'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// var cn = setTimeout(playpl(16.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(16.0);
								// $('#sndStatus').show().html('(16)');
							} else 
							if(responseDesc=="Noise: Private Carting Noise (NQ1)"){
								var arrsn = ['153', '156', '159'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(playpl(17.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(17.0);
								// $('#sndStatus').show().html('(17)');
							} else 
							if(responseDesc=="Other"){
								var arrsn = ['162', '165', '168'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(playpl(18.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(18.0);
								// $('#sndStatus').show().html('(18)');
							} else 
							if(responseDesc=="Horn Honking Sign Requested (NR9)"){
								var arrsn = ['171', '174', '177'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(playpl(19.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(19.0);
								// $('#sndStatus').show().html('(19)');
							} else 
							if(responseDesc=="21 Collection Truck Noise"){
								var arrsn = ['180', '183', '186'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(playpl(20.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(20.0);
								// $('#sndStatus').show().html('(20)');
							} else 
							if(responseDesc=="Flying Too Low"){
								var arrsn = ['189', '192', '195'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(playpl(21.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(21.0);
								// $('#sndStatus').show().html('(21)');
							} else 
							if(responseDesc=="Hovering"){
								var arrsn = ['198', '201', '204'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Noise, Other Animals (NR6)"){
								var arrsn = ['207', '210', '213'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Noise: Manufacturing Noise (NK1)"){
								var arrsn = ['217', '218', '219'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Noise: Loud Music/Nighttime(Mark Date And Time) (NP1)"){
								var arrsn = ['220', '221', '223'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Passing By"){
								var arrsn = ['224', '224', '224'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Noise: Boat(Engine,Music,Etc) (NR10)"){
								var arrsn = ['191', '192', '194'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Noise: Vehicle (NR2)"){
								var arrsn = ['198', '200', '222'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Loud Television"){
								var arrsn = ['226', '227', '228'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="NYPD"){
								var arrsn = ['236', '237', '238'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="News Gathering"){
								var arrsn = ['242', '243', '244'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else 
							if(responseDesc=="Noise: Loud Music/Daytime (Mark Date And Time) (NN1)"){
								var arrsn = ['248', '249', '250'];
								var rsn = arrsn[Math.floor(Math.random() * arrsn.length)];
								player.play(rsn);
								// setTimeout(player.play(22.00),pt*px);
								// player.play(22.0);
								// $('#sndStatus').show().html('(22)');
							} else {
								var cz = setTimeout(playpl(23.00,responseDesc,responseLtype,responseIncd,responseCnt),pt*px);
								// player.play(23.0);
							}

							// }

							$('#circled').fadeTo('fast',1);
							$('#circled').css('border-bottom', responseCnt+' solid red');
							$('#circled').css('border-top', responseCnt+' solid red');
							$('#circled').css('border-left', responseCnt+' solid red');
							$('#circled').css('border-right', responseCnt+' solid red');


						}else{
							$('#SqlStatus').show().html('<b>Unexpected Error</b><br/> <p>Please try again</p>'+response);
						}
				}
			})


			}

			function gotPosition(pos)
			{
				$("#msg").html("finding your location...");
			}
			function errorGettingPosition(err)
			{
				if(err.code==1)
				{
					$("#Output").html("User denied geolocation.");
				}
				else if(err.code==2)
				{
				$("#Output").html("Position unavailable.");
				}
				else if(err.code==3)
				{
				$("#Output").html("Timeout expired.");
				}
				else
				{
				$("#Output").html("ERROR:"+ err.message);
			}
		}
		</script>
	</head>
	<body>
		<div data-role="page" id="mainpage">
			<div data-role="header" data-id="fool">
				<a href="#about" data-icon="gear" data-rel="dialog" data-transition="flip" class="ui-btn-right">About</a>
				<h2 style="margin:0.6em 1em .8em; text-align:left;">noise city radio</h2>
			</div>
			<div data-role="content">
				<div id="cspace" style="background-repeat:no-repeat;background-position:50%;display: table; height: 120px; #position: relative; overflow: hidden;width:100%;">
					<div style="#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
					<div id="circled" class="circled" style="opacity:0;#position: relative; #top: -50%;"></div>
					</div>
				</div>
				<div id="msgs" style="height:20px;text-align:center;"></div>
     	 			<a href="#" id="btnDwn" data-icon="alert" class="button" data-role="button" style="display:block;" data-theme="e">get prepared</a>
     	 			<a href="#" id="btnLd" data-icon="refresh" class="button" data-role="button" class="button" style="display:none;" data-theme="d">one moment . .</a>
     	 			<a href="#" id="btnInit" data-icon="arrow-r" class="button" data-role="button" style="display:none;" data-theme="b">tune in</a>
     	 			<a href="#" id="btnStop" data-icon="delete" class="button" data-role="button" style="display:none;" data-theme="a">stop listening</a>
				<span id="Output" style="visbility:hidden;"></span>
				<span id="SqlStatus" style="display: block;text-align:center;"></span>
				<span id="gpsStatus"></span>
				<span id="sndStatus"></span>
				<span id="loadingtrack"></span>
			</div>
		</div>
		<div data-role="page" id="about">
			<div data-role="header" data-id="fool">
				<h2 style="margin:0.6em 5px .8em;">noise city radio</h2>
			</div>
			<div data-role="content">
			<img src="icon.png" class="ui-overlay-shadow"/><br/>
			<p>noise is only space you can't see</p>
			<p>note: the bolder the red circle, the greater the noise space you are in.</p>
			<p>by cdk and lgh</p>
			</div>
		</div>
	</body>

</html>

<?

