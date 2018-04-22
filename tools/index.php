<?php /**config**/

	$input_dir = 'in';
	$output_dir = 'out';
?>
<h1>Tools that help to work with images</h1>
<a href="?">Start</a>
<ul>
	<li><a href="javascript:;" onclick="img2frames()">Split Img into frames</a> Size:<input type="text" name="framesize" id="framesize"  size=20 value="<?=@$_GET['framesize'];?>">
	<li><a href="javascript:;" onclick="gif2frames()">Split GIF into frames</a> Name:<input type="text" name="filename" id="filename"  size=20 value="<?=@$_GET['filename'];?>">	
	<li><a href="?do=mktiles">Make tiles from flat images using alpha mask</a>
	<li><a href="?do=mktiles25d">Make 2.5 tiles from flat images using alpha mask</a>
	<li><a href="?do=magenta2alpha">Converts magenta to alpha</a>
	<li><a href="?do=white2alpha">Converts white color to alpha</a>
	<li><a href="javascript:;" onclick="frames2keyframe()">Join frames into frameset</a> Frames:<input type="text" name="imgx" id="imgx" size=3 value="<?=@$_GET['imgx'];?>">
</ul>

<script>
function img2frames() {
	var framesize = document.getElementById("framesize").value;
	window.location = '?do=img2frames&size=' + framesize;
}
function gif2frames() {
	var filename = document.getElementById("filename").value;
	window.location = '?do=gif2frames&filename=' + filename;
}
function frames2keyframe() {
	var imgx = document.getElementById("imgx").value;
	window.location = '?do=frames2keyframe&imgx=' + imgx;
}
</script>
<?php  if(isset($_GET['do']) && file_exists($_GET['do'] . '.php')) include($_GET['do'] . '.php'); ?>