<html>
<title>Jalali Lab PST API - Version 1.5.1</title>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<style>
		.flipped{
  -webkit-transform: rotate(180deg);     /* Chrome and other webkit browsers */
  -moz-transform: rotate(180deg);        /* FF */
  -o-transform: rotate(180deg);          /* Opera */
  -ms-transform: rotate(180deg);         /* IE9 */
  transform: rotate(180deg);
		}
		.panelWindow{
			background-color:#355070;
			border-radius:8px;
			padding:10px;
		}
		.invert {
  			 -webkit-filter: invert(1);
   			filter: invert(1);
  		 }
		.input_slider{
		}
		.input_slider_text{
			display:inline-block;
		}
		.marginDiv{
			display:block;
			width:100%;
			height:0px;
		}
		.title{
			text-align:center;
			font-size:36px;
		}
		a{
			color:#33ccff;
		}
		a:hover{
			color:#5555FF;
		}
		a:visited{
			color:#33ccff;
		}
		.diagram{
			margin-bottom:8px;

		}
		.stepText{
			color:#FFFF00;
		}
		#backgroundImage{
    			content : "";
   		 	display: none;
    			position: absolute;
    			top: 0;
    			left: 0;
			background-repeat: repeat;
    			background-image: url("Images/Assets/new_logo.png"); 
    			width: 2000px;
    			height: 1800px;
    			opacity: 0.05;
    			z-index: -1;	
		}
		.inputLabel{
			float:right;
			font-style: italic;
			color: #AACCFF;
		}
		#zoomLabel{
			color:#FFFFFF;
		}
		#zoomLabel:hover{
			color:#FFFFAA;
		}
		#allContent{
			display:none;
		}
		#loadingScreen{
			display:none;
		}	
		#loadingText{
			display:none;
		}
		#zoomDisplayPanel{
			display:none;
		}
	</style>
	<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
	<script>
		var camera = {position: {x: 0, y: 0}, zoom: 100, zoom_activated: false}; //position is center
		var clickOnViewer = false;
		var equationResetTimeout;
		function trigger_timeout(){
			window.clearTimeout(equationResetTimeout);
			equationResetTimeout = window.setTimeout(function(){resetAllEquations();}, 2000);
		}
		function resetAllEquations(){
			document.getElementById('blockImg').src = 'Images/Equations/block_diagram.png';
			document.getElementById('equationImg1').src = 'Images/Equations/Equation1.png';
			document.getElementById('equationImg2').src = 'Images/Equations/Equation2.png';
			document.getElementById('equationImg3').src = 'Images/Equations/Equation3.png';
			document.getElementById('equationImg4').src = 'Images/Equations/Equation4.png';
		}
		function adjustMargins(){
			var margins = [document.getElementById("import_image").height, document.getElementById("export_image").height, document.getElementById("overlay_image").height];
			var marginDivs = document.getElementsByClassName("marginDiv");
			var marginHeight = (230-margins[0])/2 + "px";
			if((230-margins[0])/2 < 5) marginHeight = "0px";
			for(var i = 0; i <= 2; i++){
				marginDivs[i].style.height = marginHeight;
			}
		}
		function regenerate_image(){
			var gaussian = document.getElementById("sigma_gaussian").value;
			var phase = document.getElementById("phase_strength").value;
			var warp = document.getElementById("warp_strength").value;
			var min = document.getElementById("min_thr").value;
			var max = document.getElementById("max_thr").value;
			var morph = document.getElementById("morph_flag").checked;
			var filename = <?php echo "'" . $_GET["file"] . "';"; ?>
			var new_filename = (Math.round(Math.random()* 1000000000)).toString() + "." + filename.substr(filename.indexOf(".")+1);
			$.ajax({'url': 'execute.php', 'type': 'GET', 'data': {'file': filename, 'new_file': new_filename, 'gaussian': gaussian, 'phase': phase, 'warp': warp, 'min': min, 'max': max, 'morph': morph}, 'success': function(data){ update_image(new_filename); } });
		}
		function update_image(n_filename){
			var filename = <?php echo "'" . $_GET["file"] . "';"; ?>
			document.getElementById("export_image").src = "EXPORTS/TEMP_" + n_filename + "?" + Math.round(Math.random()*10000000);
			document.getElementById("large_export_image").src = "EXPORTS/TEMP_" + n_filename + "?" + Math.round(Math.random()*10000000);
			document.getElementById("large_import_image").src = "UPLOADS/" + filename + "?" + Math.round(Math.random()*10000000); 
			document.getElementById("overlay_image").src = "EXPORTS/TEMP_" + n_filename.substr(0, n_filename.indexOf(".")) + "_overlay" + n_filename.substr(n_filename.indexOf(".")) + "?" + Math.round(Math.random()*10000000);
			document.getElementById("density_image").src = "EXPORTS/TEMP_" + n_filename.substr(0, n_filename.indexOf(".")) + "_density" + n_filename.substr(n_filename.indexOf(".")) + "?" + Math.round(Math.random()*10000000);
			document.getElementById("median_image").src = "EXPORTS/TEMP_" + n_filename.substr(0, n_filename.indexOf(".")) + "_median" + n_filename.substr(n_filename.indexOf(".")) + "?" + Math.round(Math.random()*10000000);
			document.getElementById("std_image").src = "EXPORTS/TEMP_" + n_filename.substr(0, n_filename.indexOf(".")) + "_std" + n_filename.substr(n_filename.indexOf(".")) + "?" + Math.round(Math.random()*10000000);
			document.getElementById("large_overlay_image").src = "EXPORTS/TEMP_" + n_filename.substr(0, n_filename.indexOf(".")) + "_overlay" + n_filename.substr(n_filename.indexOf(".")) + "?" + Math.round(Math.random()*10000000);
			document.getElementById("edge_download").href = "EXPORTS/TEMP_" + n_filename;
			document.getElementById("overlay_download").href = "EXPORTS/TEMP_" + n_filename;
			adjustMargins();
		}
 		function check_for_file(){
			if(document.getElementById("fileToUpload").value != ""){
				var evt = document.createEvent("HTMLEvents");
				evt.initEvent("click", true, true);
				document.getElementById("submit_file").dispatchEvent(evt);
			}
		}
		function error_message(message){
			if(<?php echo "'" . $_POST["uploading"] . "'"; ?> == "true"){
				alert(message);
			}
		}
		function check_state(){
			if(<?php echo "'" . $_GET["file"] . "'"; ?> == ''){
				document.getElementById("param_form").style.display = "none";
				document.getElementById("content_div").style.display = "none";
			}else{
				window.setInterval(function(){update_labels();}, 15);
			}
		}
		function update_labels(){
			document.getElementById("sigma_gaussian_label").innerHTML = "&nbsp;&nbsp;<b>" + Math.round(100*document.getElementById("sigma_gaussian").value/document.getElementById("sigma_gaussian").max) + "%</b>";
			document.getElementById("phase_strength_label").innerHTML = "&nbsp;&nbsp;<b>" + Math.round(100*document.getElementById("phase_strength").value/document.getElementById("phase_strength").max) + "%</b>";
			document.getElementById("warp_strength_label").innerHTML = "&nbsp;&nbsp;<b>" + Math.round(100*document.getElementById("warp_strength").value/document.getElementById("warp_strength").max) + "%</b>";
			document.getElementById("min_thr_label").innerHTML = "&nbsp;&nbsp;<b>" + Math.round(100*document.getElementById("min_thr").value/(document.getElementById("min_thr").max-document.getElementById("min_thr").min)) + "%</b>";
			document.getElementById("max_thr_label").innerHTML = "&nbsp;&nbsp;<b>" + Math.round(100*document.getElementById("max_thr").value/(document.getElementById("max_thr").max-document.getElementById("max_thr").min)) + "%</b>";
		}
		function viewer(which){
			document.getElementById("large_viewer").style.display = "block";
			if(which == "IMPORTS"){
			}else if(which == "EXPORTS"){
			}else{
				document.getElementById("large_viewer").style.display = "none";
			}
		}
		function viewer_opacity(opac){
			document.getElementById("large_import_image").style.opacity = opac;
			document.getElementById("large_export_image").style.opacity = 1;
			document.getElementById("large_image_opac_slider").value = opac;
		}
		function update_zoom(element, event){
			if(camera.zoom_activated){
				pos_x = event.offsetX?(event.offsetX):event.pageX-document.getElementById("pointer_div").offsetLeft;
				pos_y = event.offsetY?(event.offsetY):event.pageY-document.getElementById("pointer_div").offsetTop;
				document.getElementById(element).style.left = (pos_x-1);
				document.getElementById(element).style.top = (pos_y-15);
				camera.position.x = pos_x;
				camera.position.y = pos_y;
				redraw_canvas();
			}
		}
		function update_slider(input){
			if(input == "PHASE"){
				var currInput = document.getElementById("maxRangeBoxPhase").value;
				if(currInput == parseInt(currInput)){
					if(currInput > 1000000) currInput = 1000000;
					if(currInput > 0 && currInput != ""){
						document.getElementById("phase_strength").max = currInput;
					}
				}
			}else if(input == "WARP"){
				var currInput = document.getElementById("maxRangeBoxWarp").value;
				if(currInput == parseInt(currInput)){
					if(currInput > 1000000) currInput = 1000000;
					if(currInput > 0 && currInput != ""){
						document.getElementById("warp_strength").max = currInput;
					}
				}
			}
		}
		function resetDiagrams(){
			document.getElementById("equationImg").src = "full_equations.png";
			document.getElementById("blockImg").src = "block_diagram.png";
		}
		function checkPanelDisplay(){
			if(camera.zoom_activated){
				document.getElementById("zoomDisplayPanel").style.display = "block";
				document.getElementById("settingsDisplayPanel").style.display = "none";
			}else{
				document.getElementById("zoomDisplayPanel").style.display = "none";
				document.getElementById("settingsDisplayPanel").style.display = "block";
			}
		}
		function showAPI(){
			document.getElementById("allContent").style.display = "block";
			document.getElementById("loadingScreen").style.display = "none";
			document.getElementById("loadingText").style.display = "none";
		}
		function reset_sliders(){
			document.getElementById("sigma_gaussian").value = 0.21;
			document.getElementById("phase_strength").value = 0.5;
			document.getElementById("warp_strength").value = 12;
			document.getElementById("min_thr").value = -1;
			document.getElementById("max_thr").value = 0.02;
			document.getElementById("morph_flag").checked = "checked";
		}
	</script>
</head>
<body background="Images/Assets/background.png" onkeypress="handle_zoom(event);" style="margin-left:0px; margin-top:0px;background-color:#111828; color:#FFFFFF; font-family: 'Cabin', sans-serif;" onload="check_state(); viewer('CLOSE'); regenerate_image(); showAPI(); adjustMargins();" onclick="clickOnViewer = false; window.setTimeout(function(){if(!clickOnViewer){viewer('CLOSE');}}, 5);">

<img id="loadingScreen" src="Images/Assets/new_logo.png" style="position:absolute; width:100%; height:100%; z-index:100; margin-left:0px; margin-top:0px; margin-right:0px; margin-bottom:0px;">
<div id="loadingText" style="position:absolute; font-size:90px; text-align:center; width:100%; margin-top:30%; color:#000000; z-index:101;">Loading...</div>

</img>


<div style="position:absolute;"><a href="http://www.photonics.ucla.edu/"><img style="width:140px; height:140px; margin-left:10px; margin-top:10px;" src="Images/Assets/square_logo.png"></img></a></div>

<div id="allContent">

<div style="margin-left:auto; margin-right:auto; width:1200px;">
<?php 
if($_GET["file"] == ""){
	echo "<script>document.location.href='index.php?file=43ce848e649a3641013c691798d88a19.jpg';</script>";
}
?>

<div style="font-size:50px; text-align:center;"><b>Time Stretch Inspired Computational Imaging</b></div>
<div style="font-size:32px; text-align:center;"><i>feature enhancement in visually impaired images</i></div>
<div style="font-size:28px; text-align:center;"><b>Check out other images in the <a href="gallery.php">gallery</a>!</b></div><br><br><br><br>
<div style="font-size:48px; text-align:center;"><b>Statistical Analytics</b></div>

<br>

<div id="large_viewer" style="z-index:1; padding:10px; width:600px; height:600px; position:absolute; background-color:#223355; color:#FFFFFF;  margin-left:10%; border-radius:5px;" onclick="window.setTimeout(function(){clickOnViewer=true;}, 2);">
	<img id="large_export_image" src="" width="500px" height="500px" style="position:absolute; margin-left:5%; margin-top:8%;"></img>
	<img id="large_import_image" src="" width="500px" height="500px" style="position:absolute; margin-left:5%; margin-top:8%;"></img>
	<img id="large_overlay_image" src="" width="500px" height="500px" style="display:none; position:absolute; margin-left:5%; margin-top:5%;"></img>
		<a onclick="viewer('CLOSE');" style="align:right; text-align:right;">Close</a>
		<div style="display:block; width:600px; height:50px;"> PST Edge Image <input style="width:400px; display:inline;" type="range" min="0" max="1" step="0.05" oninput="viewer_opacity(document.getElementById('large_image_opac_slider').value)" id="large_image_opac_slider"></input> Input Image </div>
</div>

<div class="panelWindow" style="float:right; width:400px; display:block; height:465px;" id="param_form">

<div id="zoomDisplayPanel">
<canvas id="import_canvas" width="380" height="305"></canvas>
<canvas style="margin-top:8px;" id="export_canvas" width="380" height="305"></canvas>
Hover over input or edge image
</div>

<div id="settingsDisplayPanel">
<span class="stepText" style="font-size:24px;">Step 2 of 2 - Adjust settings</span>
<br>
<span style="font-size:12px;"><i>Note: allow up to 10 seconds for processing after changing input values</i></span>
<br><br>
Sigma Gaussian: <div class="input_slider_text" id="sigma_gaussian_label"></div><div class="inputLabel">filtering step</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="1" step="0.005" name="sigma_gaussian" id="sigma_gaussian" value="0.21"></input><br>
Phase Strength: <div class="input_slider_text" id="phase_strength_label"></div><div class="inputLabel">PST parameter</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="100" step="0.05" name="phase_strength" id="phase_strength" value="0.48"></input>Max Value: <input type="text" id="maxRangeBoxPhase" style="width:100px; height:24px; color:#000000;" onchange="update_slider('PHASE');" value="100"></input><br>
Warp Strength: <div class="input_slider_text" id="warp_strength_label"></div><div class="inputLabel">PST parameter</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="30" step="0.5" name="warp_strength" id="warp_strength" value="12.14"></input>Max Value: <input type="text" id="maxRangeBoxWarp" style="width:100px; height:24px; color:#000000;" onchange="update_slider('WARP');" value="30"></input><br>
Minimum Threshold: <div class="input_slider_text" id="min_thr_label"></div><div class="inputLabel">thresholding step</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="-1" max="0" step="0.005" name="min_thr" id="min_thr" value="-1"></input><br>
Maximum Threshold: <div class="input_slider_text" id="max_thr_label"></div><div class="inputLabel">thresholding step</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="1" step="0.005" name="max_thr" id="max_thr" value="0.019"></input><br>
Morphological Flag: <div class="inputLabel">morphological operation</div> <input type="checkbox" name="morph_flag" id="morph_flag" checked="checked" onchange="regenerate_image();"></input><br><br>
<button style="float:left; padding:5px; border-radius:5px; color:#000000;" onclick="reset_sliders(); regenerate_image();" value="Reset">Reset</button>

</div>
</form>

</div>	

<div id="mainContent" class="panelWindow" style="display:block; width:780px; height:375px;">

<span style="display:block; font-size:24px;"><div style="text-align:center; width:250px; float:left;">Density Image</div><div style="text-align:center; width:250px; float:left;">Median Filter</div><div style="text-align:center; width:250px; float:left;">Std Deviation</div></span>

<a onmousemove="if(camera.zoom_activated){update_zoom('import_image', event);}" onclick="if(!camera.zoom_activated){viewer('IMPORTS'); window.setTimeout(function(){clickOnViewer=true;}, 2);viewer_opacity(1);}else{update_zoom('import_image', event);} "><div style="border:solid; border-color:#336688; cursor:pointer; display:block; width:230px; height:230px; margin-left:10px; margin-right:10px; float:left;"><div class="marginDiv"></div><img id="density_image" src=<?php echo "'EXPORTS/" . substr($_GET["file"], 0, strrpos($_GET["file"], ".")) . "_density" . substr($_GET["file"], strrpos($_GET["file"], ".")) . "'"; ?> style="cursor: zoom-in; max-width:100%; max-height:100%;"></img></div></a>
<a onmousemove="if(camera.zoom_activated){update_zoom('export_image', event);}" onclick="if(!camera.zoom_activated){viewer('EXPORTS'); window.setTimeout(function(){clickOnViewer=true;}, 2); viewer_opacity(0);}else{update_zoom('export_image', event);} "><div style="border:solid; border-color:#336688; cursor: pointer; width:230px; height:230px; margin-left:10px; margin-right:10px; float:left;"><div class="marginDiv"></div><img id="median_image" src=<?php echo "'EXPORTS/" . substr($_GET["file"], 0, strrpos($_GET["file"], ".")) . "_median" . substr($_GET["file"], strrpos($_GET["file"], ".")) . "'"; ?> style="cursor: zoom-in; max-width:100%; max-height:100%;"></img></div></a>
<div style="border:solid; border-color:#336688; width:230px; height:230px; margin-left:10px; margin-right:10px; float:left;"><div class="marginDiv"></div><img id="std_image" src=<?php echo "'EXPORTS/" . substr($_GET["file"], 0, strrpos($_GET["file"], ".")) . "_std" . substr($_GET["file"], strrpos($_GET["file"], ".")) . "'"; ?> style="max-width:100%; max-height:100%;"></img></div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>

<a id="edge_download" href=<?php echo "'EXPORTS/" . $_GET["file"] . "'"; ?> download><img class="invert" style="margin-top:10px; margin-left:355px; margin-right:218px; width:35px; height:35px;" src="Images/Assets/download.png"></img></a>
<a id="overlay_download" href=<?php echo "'EXPORTS/" . substr($_GET["file"], 0, strrpos($_GET["file"], ".")) . "_overlay" . substr($_GET["file"], strrpos($_GET["file"], ".")) . "'"; ?> download><img class="invert" style="margin-top:10px; width:35px; height:35px;" src="Images/Assets/download.png"></img></a>

<br>

<br><a href="#" style="color:#FFFF00; font-size:24px; float:right;" onclick="clear_canvas(); camera.zoom_activated = !camera.zoom_activated; checkPanelDisplay();" id="zoom_label">Toggle zoom</a>

</div>

<br>



<script>

var c = document.getElementById("import_canvas");
var ctx = c.getContext("2d");

var ce = document.getElementById("export_canvas");
var ctxe = ce.getContext("2d");

var import_image = document.getElementById("large_import_image");
var export_image = document.getElementById("large_export_image");

function redraw_canvas(){
	var scale_factor = 500/camera.zoom;
	var heightString = document.getElementsByClassName("marginDiv")[0].style.height;
	var heightStringTrim = heightString.substring(0, heightString.length - 2);
	var marginOffset = parseInt(heightStringTrim);
	var mouseX = camera.position.x - (380/2.0)/scale_factor;
	var mouseY = camera.position.y + marginOffset - (305/2.0)/scale_factor;
	clear_canvas();
	ctx.drawImage(import_image, scale_factor*(-mouseX), scale_factor*(-mouseY), 230*scale_factor, 230*scale_factor);
	ctxe.drawImage(export_image, scale_factor*(-mouseX), scale_factor*(-mouseY), 230*scale_factor, 230*scale_factor);
}

function clear_canvas(){
	ctx.clearRect(0, 0, c.width, c.height);
	ctxe.clearRect(0, 0, c.width, c.height);
}

function update_viewer(){
	if(camera.zoom_activated){
		document.getElementById("import_canvas").style.display = 'inline';
		document.getElementById("export_canvas").style.display = 'inline';
	}else{
		document.getElementById("import_canvas").style.display = 'none';
		document.getElementById("export_canvas").style.display = 'none';
	}
}

function handle_zoom(type){
	console.log(type.keyCode);
	if(type.keyCode == 105){
		if(camera.zoom > 55){
			camera.zoom /= 1.1;
		}else{
			camera.zoom = 50;
		}
	}else if(type.keyCode == 111){
		if(camera.zoom < 225){
			camera.zoom *= 1.1;
		}else{
			camera.zoom = 250;
		}
	}
}

window.setInterval(function(){update_viewer();}, 50);
</script>
<br><br><br>

</div>
</body>
</html>



