<?php error_reporting(0);?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>FredEdison Control</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<style>
		body {
			padding-top: 50px;
			padding-bottom: 20px;
		}

	</style>
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/main.css">

	<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

</head>

<body>
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Fred Edison</a>
			</div>

		</div>
	</nav>

	<!-- Main jumbotron for a primary marketing message or call to action -->


	<div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-12">
				<h2>Led Control</h2>

				<table class="table">
					<tr>
						<td></td>
						<td colspan=4><b>Fred 1</b></td>
						
					</tr>
					<tr>
						<td><b>Pixel #</b></td>
						<td><b>Data A <input type="checkbox" onClick="selecta('checkA1')" /> </b></td>
						<td><b>Data B <input type="checkbox" onClick="selecta('checkB1')" /></b></td>
						<td><b>Data C <input type="checkbox" onClick="selecta('checkC1')" /> </b></td>
						<td><b>Data D <input type="checkbox" onClick="selecta('checkD1')" /></b></td>
						</tr>
					<?php
			$n=24;
			$fred1=file_get_contents("fred1.json");
			$fred1=json_decode($fred1,true);
			$total_rows = count($fred1['Data A']);
			$n = ($total_rows<$n)?$total_rows:$n;
			
					
			for ($i=$n-1;$i>=0;$i--){
				$styleA1= "style='background-color:rgb(". $fred1['Data A'][$i."A"]["R"] . ",". $fred1['Data A'][$i."A"]["G"] . ",". $fred1['Data A'][$i."A"]["B"] . ")'";
				$styleB1= "style='background-color:rgb(". $fred1['Data B'][$i."B"]["R"] . ",". $fred1['Data B'][$i."B"]["G"] . ",". $fred1['Data B'][$i."B"]["B"] . ")'";
				$styleC1= "style='background-color:rgb(". $fred1['Data C'][$i."C"]["R"] . ",". $fred1['Data C'][$i."C"]["G"] . ",". $fred1['Data C'][$i."C"]["B"] . ")'";
				$styleD1= "style='background-color:rgb(". $fred1['Data D'][$i."D"]["R"] . ",". $fred1['Data D'][$i."D"]["G"] . ",". $fred1['Data D'][$i."D"]["B"] . ")'";
				$e="<input   class=\"jscolor\" onchange=\"update1(this.jscolor)\"  value=\"select color\" style=\"width: 65px;float: right;\">";
				$e="";
			
			echo  "<tr><td><b>$i</b>$e</td>" .
						"<td id='".$i."_".checkA1."t' width=\"171px\" ". $styleA1." ><input type='checkbox' id='".$i."_".checkA1."' onclick='addcheck(\"".$i."_".checkA1."\")'> <span id='".$i."_".checkA1."s' ></span> </td> " .
						"<td id='".$i."_".checkB1."t' width=\"171px\"  ". $styleB1." ><input type='checkbox' id='".$i."_".checkB1."' onclick='addcheck(\"".$i."_".checkB1."\")'><span id='".$i."_".checkB1."s' ></span> </td> " .
						"<td id='".$i."_".checkC1."t' width=\"171px\" ". $styleC1." ><input type='checkbox' id='".$i."_".checkC1."' onclick='addcheck(\"".$i."_".checkC1."\")'> <span id='".$i."_".checkC1."s' ></span> </td> " .
						"<td id='".$i."_".checkD1."t' width=\"171px\"  ". $styleD1." ><input type='checkbox' id='".$i."_".checkD1."' onclick='addcheck(\"".$i."_".checkD1."\")'><span id='".$i."_".checkD1."s' ></span> </td> " ;
			}
			?>

				</table>

			</div>

		</div>


		<div class="row">
			<div class="col-md-12">
				<div class="col-md-6">

					<h4>Color Selection, Click to Select</h4>
					<input class="jscolor {onFineChange:'update1(this)'}" value="ffcc00">
					<br/>
					<button name="Submit" class="btn btn-primary" onClick="SendToJson()">Send to LED Controller</button>
				</div>
				<div class="col-md-6">


					<h4>Color Information</h4> toHEXString = <span id="hex-str"></span>
					<br /> toRGBString = <span id="rgb-str"></span>
					<br /> R, G, B = <span id="rgb"> <span id="r"></span><span id="g"></span><span id="b"></span></span>
					<br /> H, S, V = <span id="hsv"></span>

				</div>



				<script>
					var lst = [];
					var items = [];

					function update1(picker) {
						document.getElementById('hex-str').innerHTML = picker.toHEXString();
						document.getElementById('rgb-str').innerHTML = picker.toRGBString();

						document.getElementById('r').innerHTML =Math.round(picker.rgb[0]);
						document.getElementById('g').innerHTML =Math.round(picker.rgb[1]);
						document.getElementById('b').innerHTML =Math.round(picker.rgb[2]);

						document.getElementById('hsv').innerHTML =
							Math.round(picker.hsv[0]) + '&deg;, ' +
							Math.round(picker.hsv[1]) + '%, ' +
							Math.round(picker.hsv[2]) + '%';

						for (x in items) {

							$("#" + items[x] + "t").css("background-color", picker.toHEXString());
							$("#" + items[x] + "t").attr("value", picker.toRGBString());

							//lst[x].nid = x;
							//lst[x].R = picker.rgb[0];
							//lst[x].G = picker.rgb[1];
							//lst[x].B = picker.rgb[2];
							//lst[x].C = picker.toHEXString();
						}
						
						
						// Posting Immidieately
						console.log(JSON.stringify(items));
						r = $('#r').text();
						g = $('#g').text();
						b = $('#b').text();
						//alert(s);
						$.post("makejson.php", {
							data: JSON.stringify(items),
							r:r,
							g:g,
							b:b,
							rows:<?php echo $n;?>
						}, function(data, status) {
							console.log("Data: " + data + "\nStatus: " + status);
							//location.reload();
						});
						
						//

					}

					function update(picker) {
						document.getElementById('hex-str').innerHTML = picker.toHEXString();
						document.getElementById('rgb-str').innerHTML = picker.toRGBString();

						document.getElementById('r').innerHTML =Math.round(picker.rgb[0]);
						document.getElementById('g').innerHTML =Math.round(picker.rgb[1]);
						document.getElementById('b').innerHTML =Math.round(picker.rgb[2]);

						document.getElementById('hsv').innerHTML =
							Math.round(picker.hsv[0]) + '&deg;, ' +
							Math.round(picker.hsv[1]) + '%, ' +
							Math.round(picker.hsv[2]) + '%';

						for (x in items) {

							$("#" + items[x] + "t").css("background-color", picker.toHEXString());
							$("#" + items[x] + "t").attr("value", picker.toRGBString());

							//lst[x].nid = x;
							//lst[x].R = picker.rgb[0];
							//lst[x].G = picker.rgb[1];
							//lst[x].B = picker.rgb[2];
							//lst[x].C = picker.toHEXString();
						}
						
						
					
						
						//

					}


					function addcheck(x) {

						O = $("#" + x + "s").html();
						if (O.indexOf(" X") > -1) {
							items.pop(x);
							O = O.replace(" X", "");
							$("#" + x + "s").html(O);
						} else {
							$("#" + x + "s").html(" X");
							items.push(x);
						}

						if (x in items) {

							//		lst[x]={
							//			nid:x,
							//			R:0,
							//			G:0,
							//			B:0,
							//			C:""
							//			
							//			
							//		};
						//	items.pop(x);
						} else {
						//	items.push(x);
							//lst[x] = {
						//		nid: x,
					//			R: 0,
				//				G: 0,
			//					B: 0,
		//						C: ""


							//};
						}
					}

					function SendToJson() {
						console.log(JSON.stringify(items));
						r = $('#r').text();
						g = $('#g').text();
						b = $('#b').text();
						//alert(s);
						$.post("makejson.php", {
							data: JSON.stringify(items),
							r:r,
							g:g,
							b:b,
							rows:<?php echo $n;?>
						}, function(data, status) {
							alert("Data: " + data + "\nStatus: " + status);
							location.reload();
						});

					}
					
					function selecta(x){
						
						b=x;
						for (i=0;i<<?php echo $n;?>;i++){
							
							x=i+"_"+x;
						O = $("#" + x + "s").html();
						if (O.indexOf(" X") > -1) {
							$("#" + x + "").prop('checked', false);
							items.pop(x);
							O = O.replace(" X", "");
							$("#" + x + "s").html(O);
						} else {
							$("#" + x + "").prop('checked', true);
							$("#" + x + "s").html(" X");
							items.push(x);
						}
							
							x=b;
						
						}
					}

				</script>

			</div>
		</div>
		<hr>

		<footer>
			<p>&copy; Fred Edison 2018</p>
		</footer>
	</div>
	<!-- /container -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')

	</script>

	<script src="js/vendor/bootstrap.min.js"></script>

	<script src="js/main.js"></script>
	<script src="jscolor.js"></script>

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
	<script>
		(function(b, o, i, l, e, r) {
			b.GoogleAnalyticsObject = l;
			b[l] || (b[l] =
				function() {
					(b[l].q = b[l].q || []).push(arguments)
				});
			b[l].l = +new Date;
			e = o.createElement(i);
			r = o.getElementsByTagName(i)[0];
			e.src = '//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e, r)
		}(window, document, 'script', 'ga'));
		ga('create', 'UA-XXXXX-X', 'auto');
		ga('send', 'pageview');

	</script>
</body>

</html>
 