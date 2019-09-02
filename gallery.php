<html>
	<head>
	<style>
		.leftPanel{
			width:610px;
			float:left;
			margin-bottom:40px;
		}
		.rightPanel{
			width:610px;
			float:right;
			margin-bottom:40px;
		}
	</style>
	<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
		<script>
			function handle_mouse(action, url){
				if(action == 0){ //enter image url
					document.getElementById(url).src = "EXPORTS/" + url;
				}else{
					document.getElementById(url).src = "UPLOADS/" + url;
				}
			}
		</script>
	</head>
	<body style="background-color:#111828; color:#FFFFFF; padding:10px; font-family: 'Cabin', sans-serif; ">
	<img style="width:100%;" src="http://www.photonics.ucla.edu/image/banner/home.jpg">
	<br><span style='font-size:36px;'><b><div style="text-align:center;">Sample Images</div></b></span><br><br>
	<span style='font-size:24px;'><b><div style="text-align:center;">Natural Images</div></b></span><br>
	<?php
		$file = fopen("starred.txt","r");
		$data = fread($file, filesize("starred.txt"));
		$currFile = "error";
		while(strlen($currFile) != 0){
			if(strpos($data, "|") != -1){
				$currFile = substr($data, 0, strpos($data, "|"));
				$data = substr($data, strpos($data, "|")+1);
				if((strlen($currFile) != 0)){
					if($currFile != "divider"){
						echo "<a href='index.php?file=" . $currFile . "'><img id='" . $currFile . "' src='UPLOADS/" . $currFile . "' width='200px' height='200px' onmouseout='handle_mouse(1, " . "\"" . $currFile . "\"" . ")' onmouseover='handle_mouse(0, " . "\"" .  $currFile . "\"" . ")'></img></a>";
					}else{
						echo "<br><br><br><span style='font-size:24px;'><b><div style='text-align:center;'>Fluorescence Microscopy</div></b></span><br>";
					}
				}
			}
		}
		fclose($file);
	?>
	<br><br><br><br><br><br>

	<span style='font-size:24px;'><b><div style='text-align:center;'>Biomedical Images</div></b></span><br>
	<a href='index.php?file=bc7ca3eeedb650cdff4b2586db9219ca.jpg&sigma_gaussian=0.48&phase_strength=27.0&warp_strength=27.9'><img id='bc7ca3eeedb650cdff4b2586db9219ca.jpg' src='UPLOADS/bc7ca3eeedb650cdff4b2586db9219ca.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "bc7ca3eeedb650cdff4b2586db9219ca.jpg")' onmouseover='handle_mouse(0, "bc7ca3eeedb650cdff4b2586db9219ca.jpg")'></img></a>
	<a href='index.php?file=348436ad85a677ea5ebf9fc1bc6bb500.jpg&sigma_gaussian=0.42&phase_strength=28.7&warp_strength=26.4'><img id='348436ad85a677ea5ebf9fc1bc6bb500.jpg' src='UPLOADS/348436ad85a677ea5ebf9fc1bc6bb500.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "348436ad85a677ea5ebf9fc1bc6bb500.jpg")' onmouseover='handle_mouse(0, "348436ad85a677ea5ebf9fc1bc6bb500.jpg")'></img></a>
	<a href='index.php?file=43ce848e649a3641013c691798d88a19.jpg&sigma_gaussian=0.33&phase_strength=29.55&warp_strength=15.5'><img id='43ce848e649a3641013c691798d88a19.jpg' src='UPLOADS/43ce848e649a3641013c691798d88a19.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "43ce848e649a3641013c691798d88a19.jpg")' onmouseover='handle_mouse(0, "43ce848e649a3641013c691798d88a19.jpg")'></img></a>
	<a href='index.php?file=029bd49a18758b0b03f67eb9d9f49ddc.jpg'><img id='029bd49a18758b0b03f67eb9d9f49ddc.jpg' src='UPLOADS/029bd49a18758b0b03f67eb9d9f49ddc.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "029bd49a18758b0b03f67eb9d9f49ddc.jpg")' onmouseover='handle_mouse(0, "029bd49a18758b0b03f67eb9d9f49ddc.jpg")'></img></a>
	<a href='index.php?file=e2e2011ef9491bcd840799d9ab2f945d.jpg'><img id='e2e2011ef9491bcd840799d9ab2f945d.jpg' src='UPLOADS/e2e2011ef9491bcd840799d9ab2f945d.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "e2e2011ef9491bcd840799d9ab2f945d.jpg")' onmouseover='handle_mouse(0, "e2e2011ef9491bcd840799d9ab2f945d.jpg")'></img></a>
	<a href='index.php?file=9b35250be823af433fc11f60ab4c2d10.jpg'><img id='9b35250be823af433fc11f60ab4c2d10.jpg' src='UPLOADS/9b35250be823af433fc11f60ab4c2d10.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "9b35250be823af433fc11f60ab4c2d10.jpg")' onmouseover='handle_mouse(0, "9b35250be823af433fc11f60ab4c2d10.jpg")'></img></a>
	<a href='index.php?file=efe48f36354b7b48310118da40f29dfe.jpg'><img id='efe48f36354b7b48310118da40f29dfe.jpg' src='UPLOADS/efe48f36354b7b48310118da40f29dfe.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "efe48f36354b7b48310118da40f29dfe.jpg")' onmouseover='handle_mouse(0, "efe48f36354b7b48310118da40f29dfe.jpg")'></img></a>
	</div>

	<br><br><br><span style='font-size:24px;'><b><div style='text-align:center;'>Satellite Images</div></b></span><br>
	<a href='index.php?file=caaed91489db51355d26dc8a8ca390ae.jpg'><img id='caaed91489db51355d26dc8a8ca390ae.jpg' src='UPLOADS/caaed91489db51355d26dc8a8ca390ae.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "caaed91489db51355d26dc8a8ca390ae.jpg")' onmouseover='handle_mouse(0, "caaed91489db51355d26dc8a8ca390ae.jpg")'></img></a>
	<a href='index.php?file=a7b1650f64ad03fe2ccc7cce0ffa032d.jpg'><img id='a7b1650f64ad03fe2ccc7cce0ffa032d.jpg' src='UPLOADS/a7b1650f64ad03fe2ccc7cce0ffa032d.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "a7b1650f64ad03fe2ccc7cce0ffa032d.jpg")' onmouseover='handle_mouse(0, "a7b1650f64ad03fe2ccc7cce0ffa032d.jpg")'></img></a>
	<a href='index.php?file=42f92c886d9c7eede667bbc2dccbedd6.jpg'><img id='42f92c886d9c7eede667bbc2dccbedd6.jpg' src='UPLOADS/42f92c886d9c7eede667bbc2dccbedd6.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "42f92c886d9c7eede667bbc2dccbedd6.jpg")' onmouseover='handle_mouse(0, "42f92c886d9c7eede667bbc2dccbedd6.jpg")'></img></a>

	<br><br><br><span style='font-size:24px;'><b><div style='text-align:center;'>Visually Impaired Images</div></b></span><br>
	<a href='index.php?file=43c77a084e1c708cf3252ebd2dd100e8.jpg'><img id='43c77a084e1c708cf3252ebd2dd100e8.jpg' src='UPLOADS/43c77a084e1c708cf3252ebd2dd100e8.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "43c77a084e1c708cf3252ebd2dd100e8.jpg")' onmouseover='handle_mouse(0, "43c77a084e1c708cf3252ebd2dd100e8.jpg")'></img></a>
	<a href='index.php?file=20b3599185b402c7403b6c9628cab699.jpg'><img id='20b3599185b402c7403b6c9628cab699.jpg' src='UPLOADS/20b3599185b402c7403b6c9628cab699.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "20b3599185b402c7403b6c9628cab699.jpg")' onmouseover='handle_mouse(0, "20b3599185b402c7403b6c9628cab699.jpg")'></img></a>

	<br><br><br><span style='font-size:24px;'><b><div style='text-align:center;'>Optical Character Recognition</div></b></span><br>
	<a href='index.php?file=0456197d3ede273e41df1477241ee969.png'><img id='0456197d3ede273e41df1477241ee969.png' src='UPLOADS/0456197d3ede273e41df1477241ee969.png' width='200px' height='200px' onmouseout='handle_mouse(1, "0456197d3ede273e41df1477241ee969.png")' onmouseover='handle_mouse(0, "0456197d3ede273e41df1477241ee969.png")'></img></a>
	<a href='index.php?file=f428e9213f15b9b14703422e5f398ae9.png'><img id='f428e9213f15b9b14703422e5f398ae9.png' src='UPLOADS/f428e9213f15b9b14703422e5f398ae9.png' width='200px' height='200px' onmouseout='handle_mouse(1, "f428e9213f15b9b14703422e5f398ae9.png")' onmouseover='handle_mouse(0, "f428e9213f15b9b14703422e5f398ae9.png")'></img></a>
	<a href='index.php?file=938f05104e8e94298f481536291f9231.png'><img id='938f05104e8e94298f481536291f9231.png' src='UPLOADS/938f05104e8e94298f481536291f9231.png' width='200px' height='200px' onmouseout='handle_mouse(1, "938f05104e8e94298f481536291f9231.png")' onmouseover='handle_mouse(0, "938f05104e8e94298f481536291f9231.png")'></img></a>

	<a href='index.php?file=685730b571afcdafbd67fc94d171cc1b.png'><img id='685730b571afcdafbd67fc94d171cc1b.png' src='UPLOADS/685730b571afcdafbd67fc94d171cc1b.png' width='200px' height='200px' onmouseout='handle_mouse(1, "685730b571afcdafbd67fc94d171cc1b.png")' onmouseover='handle_mouse(0, "685730b571afcdafbd67fc94d171cc1b.png")'></img></a>
	<a href='index.php?file=0f528ca5ec6b94b79887f1641f92a2c4.png'><img id='0f528ca5ec6b94b79887f1641f92a2c4.png' src='UPLOADS/0f528ca5ec6b94b79887f1641f92a2c4.png' width='200px' height='200px' onmouseout='handle_mouse(1, "0f528ca5ec6b94b79887f1641f92a2c4.png")' onmouseover='handle_mouse(0, "0f528ca5ec6b94b79887f1641f92a2c4.png")'></img></a>
	<a href='index.php?file=831b838f46cfee1a5dab3160f94acfcc.png'><img id='831b838f46cfee1a5dab3160f94acfcc.png' src='UPLOADS/831b838f46cfee1a5dab3160f94acfcc.png' width='200px' height='200px' onmouseout='handle_mouse(1, "831b838f46cfee1a5dab3160f94acfcc.png")' onmouseover='handle_mouse(0, "831b838f46cfee1a5dab3160f94acfcc.png")'></img></a>
	<a href='index.php?file=dd5acf0cfe2fa12adda603cabe596157.png'><img id='dd5acf0cfe2fa12adda603cabe596157.png' src='UPLOADS/dd5acf0cfe2fa12adda603cabe596157.png' width='200px' height='200px' onmouseout='handle_mouse(1, "dd5acf0cfe2fa12adda603cabe596157.png")' onmouseover='handle_mouse(0, "dd5acf0cfe2fa12adda603cabe596157.png")'></img></a>
	<a href='index.php?file=30dd8ba075b4568d7cdee5ad2358fecb.png'><img id='30dd8ba075b4568d7cdee5ad2358fecb.png' src='UPLOADS/30dd8ba075b4568d7cdee5ad2358fecb.png' width='200px' height='200px' onmouseout='handle_mouse(1, "30dd8ba075b4568d7cdee5ad2358fecb.png")' onmouseover='handle_mouse(0, "30dd8ba075b4568d7cdee5ad2358fecb.png")'></img></a>
	<a href='index.php?file=d83b762231713be71d51917d261b7dc5.png'><img id='d83b762231713be71d51917d261b7dc5.png' src='UPLOADS/d83b762231713be71d51917d261b7dc5.png' width='200px' height='200px' onmouseout='handle_mouse(1, "d83b762231713be71d51917d261b7dc5.png")' onmouseover='handle_mouse(0, "d83b762231713be71d51917d261b7dc5.png")'></img></a>
	<a href='index.php?file=442ee1a02842f04e9559c7ed5ee8c73b.png'><img id='442ee1a02842f04e9559c7ed5ee8c73b.png' src='UPLOADS/442ee1a02842f04e9559c7ed5ee8c73b.png' width='200px' height='200px' onmouseout='handle_mouse(1, "442ee1a02842f04e9559c7ed5ee8c73b.png")' onmouseover='handle_mouse(0, "442ee1a02842f04e9559c7ed5ee8c73b.png")'></img></a>
	<a href='index.php?file=28285201ad65f6de5a7d78dd759d6f9e.png'><img id='28285201ad65f6de5a7d78dd759d6f9e.png' src='UPLOADS/28285201ad65f6de5a7d78dd759d6f9e.png' width='200px' height='200px' onmouseout='handle_mouse(1, "28285201ad65f6de5a7d78dd759d6f9e.png")' onmouseover='handle_mouse(0, "28285201ad65f6de5a7d78dd759d6f9e.png")'></img></a>

	<br><br><br><span style='font-size:24px;'><b><div style='text-align:center;'>Fluorescence Microscopy</div></b></span><br>

	<span style='font-size:18px;'><b><div style='text-align:center;'>Normal African Green Monkey Kidney Fibroblast Cells</div></b></span><br>
	<a href='index.php?file=98a903a48c38921eb109b4cb898cd476.jpg'><img id='98a903a48c38921eb109b4cb898cd476.jpg' src='UPLOADS/98a903a48c38921eb109b4cb898cd476.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "98a903a48c38921eb109b4cb898cd476.jpg")' onmouseover='handle_mouse(0, "98a903a48c38921eb109b4cb898cd476.jpg")'></img></a>
	<a href='index.php?file=60ac6d63c8456fa774b72b96b1052193.jpg'><img id='60ac6d63c8456fa774b72b96b1052193.jpg' src='UPLOADS/60ac6d63c8456fa774b72b96b1052193.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "60ac6d63c8456fa774b72b96b1052193.jpg")' onmouseover='handle_mouse(0, "60ac6d63c8456fa774b72b96b1052193.jpg")'></img></a>

	<br><br><br><span style='font-size:18px;'><b><div style='text-align:center;'>Transformed (Simian Virus 40) African Green Monkey Kidney Fibroblast Cells (COS-7 Line)</div></b></span><br>
	<a href='index.php?file=f1f6019f32b294a1daa32bbe591b2c28.jpg'><img id='f1f6019f32b294a1daa32bbe591b2c28.jpg' src='UPLOADS/f1f6019f32b294a1daa32bbe591b2c28.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "f1f6019f32b294a1daa32bbe591b2c28.jpg")' onmouseover='handle_mouse(0, "f1f6019f32b294a1daa32bbe591b2c28.jpg")'></img></a>
	<a href='index.php?file=660daa1af4b8954d254e62c7510de7b2.jpg'><img id='660daa1af4b8954d254e62c7510de7b2.jpg' src='UPLOADS/660daa1af4b8954d254e62c7510de7b2.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "660daa1af4b8954d254e62c7510de7b2.jpg")' onmouseover='handle_mouse(0, "660daa1af4b8954d254e62c7510de7b2.jpg")'></img></a>
	<a href='index.php?file=74125446f64a7a7047de7000b07a7b28.jpg'><img id='74125446f64a7a7047de7000b07a7b28.jpg' src='UPLOADS/74125446f64a7a7047de7000b07a7b28.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "74125446f64a7a7047de7000b07a7b28.jpg")' onmouseover='handle_mouse(0, "74125446f64a7a7047de7000b07a7b28.jpg")'></img></a>

	<br><br><br><span style='font-size:18px;'><b><div style='text-align:center;'>Guinea Pig Colorectal Adenocarcinoma Epithelial Cells (GPC-16 Line)</div></b></span><br>
	<a href='index.php?file=15766d3f339e06e218dbc2d9e4126999.jpg'><img id='15766d3f339e06e218dbc2d9e4126999.jpg' src='UPLOADS/15766d3f339e06e218dbc2d9e4126999.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "15766d3f339e06e218dbc2d9e4126999.jpg")' onmouseover='handle_mouse(0, "15766d3f339e06e218dbc2d9e4126999.jpg")'></img></a>

	<br><br><br><span style='font-size:18px;'><b><div style='text-align:center;'>Rat Brain Tissue Sections</div></b></span><br>
	<a href='index.php?file=0c0d9a3d78e789f6434260779698c8a6.jpg'><img id='0c0d9a3d78e789f6434260779698c8a6.jpg' src='UPLOADS/0c0d9a3d78e789f6434260779698c8a6.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "0c0d9a3d78e789f6434260779698c8a6.jpg")' onmouseover='handle_mouse(0, "0c0d9a3d78e789f6434260779698c8a6.jpg")'></img></a>
   	<a href='index.php?file=1dd5f97202e1cbd6453ab0597da826af.jpg'><img id='1dd5f97202e1cbd6453ab0597da826af.jpg' src='UPLOADS/1dd5f97202e1cbd6453ab0597da826af.jpg' width='200px' height='200px' onmouseout='handle_mouse(1, "1dd5f97202e1cbd6453ab0597da826af.jpg")' onmouseover='handle_mouse(0, "1dd5f97202e1cbd6453ab0597da826af.jpg")'></img></a>

	</body>

</html>
