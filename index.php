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
		.selectionButton{
			width:300px;
			margin-left:100px;
			height:50px;
			background-color:#7766DD;
			border-radius:5px;
			padding:10px;
			margin-top:10px;
			font-size:16px;
			text-align:center;
			color:#FFFFFF;
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
			var marginHeight = (363-margins[0])/2 + "px";
			if((363-margins[0])/2 < 5) marginHeight = "0px";
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
			document.getElementById("large_overlay_image").src = "EXPORTS/TEMP_" + n_filename.substr(0, n_filename.indexOf(".")) + "_overlay" + n_filename.substr(n_filename.indexOf(".")) + "?" + Math.round(Math.random()*10000000);
			document.getElementById("edge_download").href = "EXPORTS/TEMP_" + n_filename;
			document.getElementById("overlay_download").href = "EXPORTS/TEMP_" + n_filename;
			document.getElementById("stats_link").href = "stats.php?file=TEMP_" + n_filename;
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
				document.getElementById("commentType") = "Please tell us what you enjoyed!";
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
				document.getElementById("settingsDisplayPanel2").style.display = "none";
			}else{
				document.getElementById("zoomDisplayPanel").style.display = "none";
				document.getElementById("settingsDisplayPanel").style.display = "block";
				document.getElementById("settingsDisplayPanel2").style.display = "block";
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
		function comment(type){
			document.getElementById("selectionArea").style.display="none";
			document.getElementById("commentArea").style.display="block";
			document.getElementById("submitButtonComment").style.display="block";
			if(type==0){
				document.getElementById("commentType").innerHTML = "Please report the bug you found below. Be meticulous in naming the steps you took to achieve it.";
			}
			if(type==1){
				document.getElementById("commentType").innerHTML = "Please tell us what you enjoyed!";
			}
			if(type==2){
				document.getElementById("commentType").innerHTML = "Please make any suggestions that you feel would improve the quality of the site.";
			}
			if(type==3){
				document.getElementById("commentType").innerHTML = "Please let us know where you found the inappropriate content. Links to the offending pages are generally helpful.";
			}
		}
		function setSliders(){
			<?php 
			if(isset($_GET["sigma_gaussian"])){
				echo 'document.getElementById("sigma_gaussian").value = ' . $_GET["sigma_gaussian"] . ';';
			}else{
				echo 'document.getElementById("sigma_gaussian").value = 0.21;';
			}

			if(isset($_GET["phase_strength"])){
				echo 'document.getElementById("phase_strength").value = ' . $_GET["phase_strength"] . ';';
			}else{
				echo 'document.getElementById("phase_strength").value = 0.48;';
			}


			if(isset($_GET["warp_strength"])){
				echo 'document.getElementById("warp_strength").value = ' . $_GET["warp_strength"] . ';';
			}else{
				echo 'document.getElementById("warp_strength").value = 12.14;';
			}


			if(isset($_GET["min_thr"])){
				echo 'document.getElementById("min_thr").value = ' . $_GET["min_thr"] . ';';
			}else{
				echo 'document.getElementById("min_thr").value = -1;';
			}


			if(isset($_GET["max_thr"])){
				echo 'document.getElementById("max_thr").value = ' . $_GET["max_thr"] . ';';
			}else{
				echo 'document.getElementById("max_thr").value = 0.019;';
			}
			?>
		}
	</script>
<?php
$target_dir = "UPLOADS/";
$target_filename = basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($target_filename, PATHINFO_EXTENSION);
$target_file = hash("md5", uniqid()) . "." . $imageFileType;
$target_path = $target_dir . $target_file;

$uploadOk = 1;
// Check if image file is a actual image or fake image
if($_POST["remoteURL"] != ""){
	$final_file = $target_file . substr($_POST["remoteURL"], strrpos($_POST["remoteURL"], '.')+1);
	copy($_POST["remoteURL"], $target_dir . $final_file);
	echo "<script>document.location.href='index.php?file=" . $final_file . "';</script>";	
}else{
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
    //    echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;    } else {
        echo "<script>error_message('File is not an image.');</script>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_path)) {
    echo "<script>error_message('Sorry, file already exists.');</script>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "<script>error_message('Sorry, your file is too large. The maximum file size is 5 MB.');</script>";
    $uploadOk = 0;
}

$lowerFileType = strtolower($imageFileType);
// Allow certain file formats
if($lowerFileType != "jpg" && $lowerFileType != "jpeg" && $lowerFileType != "gif" && $lowerFileType != "png" && $lowerFileType != "tiff" && $lowerFileType != "bmp") {
    echo "<script>error_message('Sorry, only JPG, JPEG, GIF, PNG, TIFF, & BMP files are allowed.');</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script>error_message('Sorry, your file was not uploaded.');</script>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_path)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
 	echo "<script>document.location.href='index.php?file=" . $target_file . "';</script>";
    } else {
        echo "<script>error_message('Sorry, there was an error uploading your file.');</script>";
    }
}
}
?>
</head>
<body background="Images/Assets/background.png" onkeypress="handle_zoom(event);" style="margin-left:0px; margin-top:0px; background-color:#111828; color:#FFFFFF; font-family: 'Cabin', sans-serif;" onload="check_state(); viewer('CLOSE'); showAPI(); adjustMargins(); setSliders(); regenerate_image();" onclick="clickOnViewer = false; window.setTimeout(function(){if(!clickOnViewer){viewer('CLOSE');}}, 5);">

<img id="loadingScreen" src="Images/Assets/new_logo.png" style="position:absolute; width:100%; height:100%; z-index:100; margin-left:0px; margin-top:0px; margin-right:0px; margin-bottom:0px;">
<div id="loadingText" style="position:absolute; font-size:90px; text-align:center; width:100%; margin-top:30%; color:#000000; z-index:101;">Loading...</div>

</img>

<div style="position:absolute;"><a href="http://www.photonics.ucla.edu/"><img style="width:140px; height:140px; margin-left:10px; margin-top:10px;" src="Images/Assets/square_logo.png"></img></a></div>

<div id="allContent" style="zoom:0.9;">

<div style="margin-left:auto; margin-right:auto; width:1200px;">
<?php
if($_GET["file"] == ""){
	echo "<script>document.location.href='index.php?file=43ce848e649a3641013c691798d88a19.jpg';</script>";
}
?>

<div style="font-size:50px; text-align:center;"><b>Time Stretch Computational Imaging</b></div>
<div style="font-size:32px; text-align:center;"><i>Feature enhancement in visually impaired images</i></div>
<div style="font-size:28px; text-align:center;"><b>Check out other images in the <a href="gallery.php">gallery</a>!</b></div>
<br>
<div id="large_viewer" style="z-index:1; padding:10px; width:900px; height:900px; position:absolute; background-color:#223355; color:#FFFFFF;  margin-left:10%; border-radius:5px;" onclick="window.setTimeout(function(){clickOnViewer=true;}, 2);">
	<img id="large_export_image" src="" width="800px" style="position:absolute; margin-left:5%; margin-top:8%;"></img>
	<img id="large_import_image" src="" width="800px" style="position:absolute; margin-left:5%; margin-top:8%;"></img>
	<img id="large_overlay_image" src="" width="800px" style="display:none; position:absolute; margin-left:5%; margin-top:5%;"></img>
	<a onclick="viewer('CLOSE');" style="align:right; text-align:right;">Close</a>
	<div style="margin-left:250px;">Overlay Transparency</div>
	<div style="display:block; width:600px; height:50px;"> PST Edge Image <input style="width:400px; display:inline;" type="range" min="0" max="1" step="0.05" oninput="viewer_opacity(document.getElementById('large_image_opac_slider').value)" id="large_image_opac_slider"></input> Input Image </div>
</div>


<br><br>

<div id="mainContent" class="panelWindow" style="display:block; width:1200px; height:510px; margin-bottom:25px;">

<span style="display:block; font-size:24px;"><div style="text-align:center; width:382px; float:left;">Input Image</div><div style="text-align:center; width:382px; float:left;">PST Edge Image</div><div style="text-align:center; width:382px; float:left;">Overlay Image</div></span>

<div style="float:left; display:block;">
<a onmousemove="if(camera.zoom_activated){update_zoom('import_image', event);}" onclick="if(!camera.zoom_activated){viewer('IMPORTS'); window.setTimeout(function(){clickOnViewer=true;}, 2);viewer_opacity(1);}else{update_zoom('import_image', event);} "><div style="border:solid; border-color:#336688; cursor:pointer; display:block; width:363px; height:363px; margin-left:10px; margin-right:10px; float:left;"><div class="marginDiv"></div><img id="import_image" src=<?php echo "'UPLOADS/" . filter_var($_GET["file"], FILTER_SANITIZE_STRING) . "'"; ?> style="cursor: zoom-in; max-width:100%; max-height:100%;"></img></div></a>
<a onmousemove="if(camera.zoom_activated){update_zoom('export_image', event);}" onclick="if(!camera.zoom_activated){viewer('EXPORTS'); window.setTimeout(function(){clickOnViewer=true;}, 2); viewer_opacity(0);}else{update_zoom('export_image', event);} "><div style="border:solid; border-color:#336688; cursor: pointer; width:363px; height:363px; margin-left:10px; margin-right:10px; float:left;"><div class="marginDiv"></div><img id="export_image" src=<?php echo "'EXPORTS/" . filter_var($_GET["file"], FILTER_SANITIZE_STRING) . "'"; ?> style="cursor: zoom-in; max-width:100%; max-height:100%;"></img></div></a>
	<div style="border:solid; border-color:#336688; width:363px; height:363px; margin-left:10px; margin-right:10px; float:left;"><div class="marginDiv"></div><img id="overlay_image" src=<?php echo "'EXPORTS/" . substr($_GET["file"], 0, strrpos($_GET["file"], ".")) . "_overlay" . substr($_GET["file"], strrpos($_GET["file"], ".")) . "'"; ?> style="max-width:100%; max-height:100%;"></img></div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>

<a id="edge_download" href=<?php echo "'EXPORTS/" . $_GET["file"] . "'"; ?> download><img class="invert" style="margin-top:10px; margin-left:555px; margin-right:347px; width:35px; height:35px;" src="Images/Assets/download.png"></img></a>
<a id="overlay_download" href=<?php echo "'EXPORTS/" . substr($_GET["file"], 0, strrpos($_GET["file"], ".")) . "_overlay" . substr($_GET["file"], strrpos($_GET["file"], ".")) . "'"; ?> download><img class="invert" style="margin-top:10px; width:35px; height:35px;" src="Images/Assets/download.png"></img></a>

<br><a href="#" id="stats_link" style="color:#FFF00; font-size:24px; float:left; margin-right:825px; margin-top:20px;">Statistical Analytics</a>
<br><a href="#" style="color:#FFFF00; font-size:24px; cursor:zoom-in;" onclick="clear_canvas(); camera.zoom_activated = !camera.zoom_activated; checkPanelDisplay();" id="zoom_label">Toggle zoom</a><img src="Images/Assets/zoom.png" width="20px" style="float:right;margin-top:5px;" class="invert"></img>
<br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<div style="width:1200px; height:350px;" class="panelWindow">

<div style="width:560px; display:block; float:left; margin-right:25px; margin-top:3px; margin-bottom:25px; height:200px;">

<canvas id="import_canvas" width="580" height="325"></canvas>

<div id="settingsDisplayPanel">
<span class="stepText" style="font-size:24px;">Step 1 of 2 - Upload Image</span><br><br>
<form action="index.php" method="post" enctype="multipart/form-data" style="float:left; margin-top:-10px; height:60px; width:500px;">
    <input type="image" src='Images/Assets/download.png' class='flipped invert' style="display:inline; margin-right:20px; margin-top:8px; width:35px; height:35px; float:right;" id="submit_file" value="Upload Image" name="submit"></input>
    <input type="file" style="width:180px;" src='download.png' name="fileToUpload" id="fileToUpload"></input>
    <input style="display:none;" type="text" value="true" name="uploading"></input>

    <div>
    <br>Or input the link to an image: <input type="text" style="color:#000000; width:140px;" name="remoteURL"></input>
    </div>
</form>
<br><br><br><br><br><br>
<span class="stepText" style="font-size:24px;">Step 2 of 2 - Adjust settings</span>
<br>
<span style="font-size:12px;"><i>Note: allow up to 10 seconds for processing after changing input values</i></span>
<br><br>
Sigma Gaussian: <div class="input_slider_text" id="sigma_gaussian_label"></div><div class="inputLabel">filtering step</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="1" step="0.005" name="sigma_gaussian" id="sigma_gaussian" value="0.21"></input><br>
</div>

<br><br><br><br><br>
<div id="zoomDisplayPanel">
Hover over input or edge image
</div>

</div>

<div style="width:575px; display:block; float:left; margin-top:3px; margin-bottom:25px;">

<canvas id="export_canvas" width="580" height="325"></canvas>

<div id="settingsDisplayPanel2">
<div style="float:left; width:400px;">Phase Strength: <div class="input_slider_text" id="phase_strength_label"></div><div class="inputLabel">PST parameter</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="30" step="0.05" name="phase_strength" id="phase_strength" value="0.48"></input></div>
<div style="float:right; margin-top:16px;">Max Value: <input type="text" id="maxRangeBoxPhase" style="width:100px; height:24px; color:#000000;" onchange="update_slider('PHASE');" value="30"></input></div><br>
<div style="float:left; width:400px; margin-top:24px;">Warp Strength: <div class="input_slider_text" id="warp_strength_label"></div><div class="inputLabel">PST parameter</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="30" step="0.5" name="warp_strength" id="warp_strength" value="12.14"></input></div>
<div style="float:right; margin-top:40px;">Max Value: <input type="text" id="maxRangeBoxWarp" style="width:100px; height:24px; color:#000000;" onchange="update_slider('WARP');" value="30"></input></div>
<div style="margin-top:110px;">Minimum Threshold: <div class="input_slider_text" id="min_thr_label"></div><div class="inputLabel">thresholding step</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="-1" max="0" step="0.005" name="min_thr" id="min_thr" value="-1"></input><br></div>
<div style="margin-top:10px">Maximum Threshold: <div class="input_slider_text" id="max_thr_label"></div><div class="inputLabel">thresholding step</div> <input class="input_slider" type="range" onmousedown="regenerate_image(); trigger_timeout();" min="0" max="1" step="0.005" name="max_thr" id="max_thr" value="0.019"></input><br></div>
Morphological Flag: <div class="inputLabel">morphological operation</div> <input type="checkbox" name="morph_flag" id="morph_flag" checked="checked" onchange="regenerate_image();"></input><br>
<br><button style="float:left; padding:5px; border-radius:5px; color:#000000;" onclick="reset_sliders(); regenerate_image();" value="Reset">Reset</button>
</div>
</div>
</div>
<br>

<div style="display:block; float:left; height:680px;">
<div class="panelWindow">
<span style="display:block; font-size:36px; width:650px; text-align:center;"><b>PST Block Diagram</b></span><br>
<img class="diagram" id="blockImg" src="Images/Equations/block_diagram.png" style="width:650px;"></img><br>
</div>

<div style="display:block; width:680px; margin-top:25px;" class="panelWindow">
<span style="display:block; font-size:30px; width:650px; text-align:center;"><b>Mathematics of Phase Stretch [PST] Algorithm</b></span>
<img class="diagram invert" id="equationImg1" src="Images/Equations/Equation1.png" style="width:660px"></img><br>
<img class="diagram invert" id="equationImg2" src="Images/Equations/Equation2.png" style="width:300px; margin-left:175px; margin-top:-25px;"></img><br>
<img class="diagram invert" id="equationImg3" src="Images/Equations/Equation3.png" style="width:180px; margin-left:240px; margin-bottom:30px;"></img><br>
<img class="diagram invert" src="Images/Equations/PictureLarge1.png" style="width:600px;"></img><br>
<img class="diagram invert" id="equationImg4" src="Images/Equations/Equation4.png" style="width:660px; margin-top:30px; margin-bottom:30px;"></img><br>
<img class="diagram invert" src="Images/Equations/PictureLarge4.png" style="width:400px;"></img><br>
</div>

</div>


<div class="panelWindow" style="height:852px;float:right;">
<div class="title" style="text-align:center; margin-bottom:25px;"><b>News and Announcements</b></div>

<div style="font-size:16px; width:480px;">
The Phase Stretch Tranform algorithm was among the Top 11 in the <a href="https://www.mathworks.com/matlabcentral/fileexchange/55330-jalalilabucla-image-feature-detection-using-phase-stretch-transform?requestedDomain=www.mathworks.com">MATLAB file exchange</a>, downloaded over 26,500 times.
<br><br><br>Additionally, the Phase Stretch Transform algorithm was viewed over 28,000 times on <a href="https://github.com/JalaliLabUCLA/Image-feature-detection-using-Phase-Stretch-Transform">GitHub</a>.
<br><br><br>The Phase Stretch Transform algorithm, as it is known, is a physics-inspired computational approach to processing images and information. The algorithm grew out of UCLA research on a technique called photonic time stretch, which has been used for ultrafast imaging and detecting cancer cells in blood. The algorithm also helps computers see features of objects that aren't visible using standard imaging techniques. 
</div>

<br><br><br><a href="http://newsroom.ucla.edu/releases/ucla-researchers-release-open-source-code-for-powerful-image-detection-algorithm"><img src="Images/Assets/news_article.png" style="float:right; width:480px;"></img></a>
</div>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
	var mouseX = camera.position.x - (580/2.0)/scale_factor;
	var mouseY = camera.position.y + marginOffset - (325/2.0)/scale_factor;
	clear_canvas();
	ctx.drawImage(import_image, scale_factor*(-mouseX), scale_factor*(-mouseY), 363*scale_factor, 363*scale_factor);
	ctxe.drawImage(export_image, scale_factor*(-mouseX), scale_factor*(-mouseY), 363*scale_factor, 363*scale_factor);
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

<br><br><br><br><br><br><br><br><br><br><br>

<div id="footer" style="margin-left:auto; margin-right:auto; width:1200px; font-size:12px;" class="panelWindow">
<span class="title" style="text-align:center;"><b><div style="text-align:center;">References</div></b></span>
<br><br>
1. Asghari, M. H., & Jalali, B. (2015). Edge detection in digital images using dispersive phase stretch transform. <i>Journal of Biomedical Imaging, 2015</i>, 6. <a href="https://www.hindawi.com/journals/ijbi/2015/687819/">PDF</a>
<br>2. Asghari, M. H., & Jalali, B. (2014, December). Physics-inspired image edge detection. In <i>Signal and Information Processing (GlobalSIP), 2014 IEEE Global Conference on (pp. 293-296)</i>. IEEE. <a href="https://www.hindawi.com/journals/ijbi/2015/687819/">PDF</a>
<br>3. Suthar, M., Mahjoubfar, A., Seals, K., Lee, E. W., & Jalali, B. (2016, July). Diagnostic tool for pneumothorax. In <i>Photonics Society Summer Topical Meeting Series (SUM), 2016 IEEE </i>(pp. 218-219). IEEE. <a href="http://ieeexplore.ieee.org/stamp/stamp.jsp?arnumber=7548806">PDF</a>
<br>4. Jalali B., Suthar M., Asghari M. and Mahjoubfar A. (2017). Optics-inspired Computing. In <i>Proceedings of the 5th International Conference on Photonics, Optics and Laser Technology - Volume 1: PHOTOPTICS</i>, ISBN 978-989-758-223-3, pages 340-345. DOI: 10.5220/0006271703400345
<br>5. Ilovitsh, T., Jalali, B., Asghari, M. H., & Zalevsky, Z. (2016). Phase stretch transform for super-resolution localization microscopy. <i>Biomedical Optics Express,</i> 7(10), 4198-4209.
<br>6. Mahjoubfar, A., Churkin, D. V., Barland, S., Broderick, N., Turitsyn, S. K., & Jalali, B. (2017). Time stretch and its applications. <i>Nature Photonics, 11(6),</i> 341-351.
<br>7. Suthar M., Asghari M., Mahjoubfar M., & Jalali, B. (2017). Time Stretch Inspired Computational Imaging. arXiv:1706.07841
<br>8. Suthar M., Ashgari M., & Jalali B. (2017). Feature Enhancement in Visually Impaired Images. arXiv:1706.04671
<br>
<div style="font-size:14px;">More information can be found on the <a href="https://en.wikipedia.org/wiki/Phase_stretch_transform">wiki</a> page.</div>
</div>

<div style="margin-left:auto; margin-right:auto; width:1200px; height:375px; margin-top:25px;" class="panelWindow">
<div class="title" style="text-align:center;"><b>Project Members</b></div>

<div style="width:360px; float:left;">
<div style="height:130px; width:100px; float:left; margin-right:10px; margin-left:115px;">
<img src="Images/Assets/jalali.jpg" width="120px" style="float:left;"></img>
</div>
<div style="height:100px; width:360px; float:left; margin-top:10px; text-align:center;">
<br><b>Bahram Jalali, Ph.D.</b>
<br>Professor, Northrop Grumman Endowed Chair
<br>Departments of Electrical Engineering & Bioengineering
<br>Department of Surgery, David Geffen School of Medicine
<br>California NanoSystems Institute
<br><br><br>
For more information, see <a href="http://www.photonics.ucla.edu">Jalali-Lab at UCLA</a>.
</div>
</div>

<div style="width:380px; float:left;">
<div style="height:100px; width:100px; float:left; margin-right:10px; margin-left:115px;">
<img src="Images/Assets/madhuri.jpg" width="150px" style="float:left;"></img>
</div>
<div style="height:100px; width:380px; float:left; text-align:center; margin-top:50px;">
<br><b>Madhuri Suthar</b>
<br>Ph.D. Candidate
<br>Department of Electrical Engineering
<br>B.Tech., ECE, ISM Dhanbad
</div>
</div>

<div style="width:400px; float:left;">
<div style="height:100px; width:100px; float:left; margin-right:10px; display:block; margin-left:125px;">
<img src="Images/Assets/jonathan.jpg" width="150px" style="float:left;"></img>
</div>
<div style="height:100px; width:400px; float:left; margin-right:80px; text-align:center; margin-top:45px;">
<br><b>Jonathan Mendelson</b> 
<br>Working as a research intern at Professor Jalali's Lab
<br>Brentwood High School
<br>Los Angeles
</div>
</div>
</div>

<div style="width:500px; float:left; height:635px; margin-top:25px;" class="panelWindow">
	<div class="title" style="text-align:center; margin-bottom:25px;"><b>Contact Form</b></div>
	<form action="comment.php" method="POST">
	Name/Title: <input type="text" name="commenterName" style="color:#000000;"></input>
	<br><br>

	<div id="selectionArea" style="display:block;">
		<a onclick="comment(0);"><div class="selectionButton" onclick="comment(0);">Bug Report</div></a>
		<a onclick="comment(1);"><div class="selectionButton" onclick="comment(1);">Compliment</div></a>
		<a onclick="comment(2);"><div class="selectionButton" onclick="comment(2);">Suggestion</div></a>
		<a onclick="comment(3);"><div class="selectionButton" onclick="comment(3);">Report Inappropriate Content</div></a>
	</div>


	<div id="commentArea" style="display:none;">
		<div id="commentType">Please select an option first.</div>
		<textarea name="comment" rows="6" columns="30" style="color:#000000; margin: 0px; width: 480px; height: 410px;" placeholder="Please type your response here"></textarea>
	</div>

	<input type="submit" id="submitButtonComment" style="display:none;font-size:24px; color:#000000; margin-left:auto; margin-right:auto;" value="Send us your comment!"></input>
	</form>
</div>

<div style="width:680px; float:right; height:635px; margin-top:25px; margin-bottom:15px; font-size:13px;" class="panelWindow">
<span style="font-size:24px;"><b>Terms of Use ("Terms")</b></span>
<br>
Last updated: June 27, 2017
<br><br>
Please read these Terms of Use ("Terms", "Terms of Use") carefully before using the Phase Stretch Transform ("PST") API.
<br><br>
Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the PST API.
<br><br>
<b>Uploading</b><br>
Uploading content to the PST API that could be considered harmful, upsetting, or otherwise provocative is a breach of the Terms of Service and will likely result in Termination. Such content include, but are not limited to, depictions of violence, sexual acts/nudity, or illegal activities. The PST API team reserves the rights to decide which content is inappropriate and to terminate access at its discretion.
<br><br>
<b>Termination</b><br>
We may terminate or suspend access to the PST API immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.
<br><br>
<b>Content</b><br>
The PST API may contain images uploaded by users that are not owned, controlled, or approved in any way by the PST API team. The PST API team assumes no responsibility for the content uploaded to its web service. You further acknowledge and agree that the PST API shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content.
<br><br>
<b>Changes</b><br>
We reserve the right, at our sole discretion, to modify or replace these Terms of Service at any time.
<br>
By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.
<br><br>
<b>Contact Us</b><br>
If you have any questions about these Terms, please contact us.
</div>

</div>

</div>
<br><br>
</body>
</html>



