#! /usr/bin/php
<?php

//  DECLARE VERSION
$version = "v0.7.3";

//  ARGUMENT GETTER
$shortopts  = "";
$shortopts .= "b:";
$shortopts .= "i:";
$shortopts .= "w:";
$shortopts .= "h:";
$shortopts .= "v";
$shortopts .= "z:";
$longopts  = ["help","wireframe"];
$options = getopt($shortopts, $longopts);
//  DEFAULT CONFIG
if (!isset($options["b"])) {$options["b"] = "#FFF";}
if (!isset($options["w"])) {$options["w"] = 640;}
if (!isset($options["h"])) {$options["h"] = 480;}
if (!isset($options["z"])) {$options["z"] = 1.8;}
//  CHECK FOR VALID ASPECT RATIO
if (!isset($options["help"]) && $options["w"] > $options["h"] * 100) {fwrite(STDERR,"ERROR: Width may not be greater than 100x height\n");exit(1);}
//  ENDOF ARGUMENT GETTER

//  HELP
if (isset($options["help"])) {
	echo "Vector3D " . $version . " 2018-10-13 Joe Koop\n";
	echo "Usage:   ./vector3d.php [options] > [output.svg]\n";
	echo "Example: ./vector3d.php -i cube -z 1 > file.svg\n\n";
	echo "	-b			 background colour;	default: #FFF\n";
	echo "	-i			 v3d compliant file for input\n";
	echo "	-h			 height of output svg; default: 480\n";
	echo "	-w			 width of ouput svg;   default: 640\n";
	echo "	-v			 print version and exit\n";
	echo "	-z			 zoom multipier; 1 = 90° view angle\n";
	echo "				   default: 1.8	2 ≈ 40°\n";
	echo "								   3 ≈ 26°\n";
	echo "								   4 ≈ 20°\n";
	echo "				   sine( √2 / 2z ) --> degrees / 2\n";
	echo "	--help		 print this help and exit\n";
	echo "	--wireframe	render wireframe\n";
	exit(0);
}

//  PRINT VERSION
if (isset($options["v"])) {echo $version . "\n";exit(0);}

//  CHECK IF INPUT FILE EXISTS
if (isset($options["i"])) {if (!file_exists($options["i"])) {fwrite(STDERR,"ERROR: Input file does not exist\n");exit(1);}} else {fwrite(STDERR,"ERROR: Input file not defined; try --help\n");exit(1);}

//  LOAD INPUT FILE
$faces = json_decode(file_get_contents($options["i"]));

/*  REMOVE FACES WITH NEGATIVE Z
for ($i = 0; $i < count($faces); $i++) {
	checkforandremovefaceswithallnegativez($i);
}

function checkforandremovefaceswithallnegativez($i) {
	global $faces;
	if ($faces[$i][1][2] <= 0 && $faces[$i][2][2] <= 0 && $faces[$i][3][2] <= 0) {
		$faces = array_splice($faces, $i, 1);
//		checkforandremovefaceswithallnegativez($i);
	}
}*/

//  FACE SORTER
for ($i = 0; $i < count($faces); $i++) {
	$faces[$i][4] = ($faces[$i][1][2] + $faces[$i][2][2] + $faces[$i][3][2]) / 3;
}
usort($faces, "compare");
function compare($a,$b){
	if ($a[4] < $b[4]) {
		return 1;
	}
	if ($a[4] == $b[4]) {
		return 0;
	}
	if ($a[4] > $b[4]) {
		return -1;
	}
}
//  ENDOF FACE SORTER

//  SHADING TRIANGLES
function triangleshading($i) {
	$hexcolour = str_replace("#","",$i[0]);
	if (strlen($hexcolour) == 6) {
		$red = substr($hexcolour, 0, 2);
		$grn = substr($hexcolour, 2, 2);
		$blu = substr($hexcolour, 4, 2);
	} elseif (strlen($hexcolour) == 3) {
		$red = substr($hexcolour, 0, 2).substr($hexcolour, 0, 2);
		$grn = substr($hexcolour, 2, 2).substr($hexcolour, 2, 2);
		$blu = substr($hexcolour, 4, 2).substr($hexcolour, 4, 2);
	} else {
		fwrite(STDERR,"ERROR: Invalid colour \"" . $i . "\"\n");
		exit(1);
	}
	if (strlen($red)==1) $red=$red.$red;
	if (strlen($grn)==1) $grn=$grn.$grn;
	if (strlen($blu)==1) $blu=$blu.$blu;
	$red = hexdec($red)/242;
	$grn = hexdec($grn)/242;
	$blu = hexdec($blu)/242;
	
	// ANGLE FIGURER
	
 $v = [0, 1, 0];
 $P = $i[1];
 $Q = $i[2];
 $R = $i[3];

 $n = [[$Q[0]-$P[0], $Q[1]-$P[1], $Q[2]-$P[2]], [$R[0]-$P[0], $R[1]-$P[1], $R[2]-$P[2]]];
 $n = [$n[0][1] * $n[1][2] - $n[0][2] * $n[1][1], $n[0][2] * $n[1][0] - $n[0][0] * $n[1][2], $n[0][0] * $n[1][1] - $n[0][1] * $n[1][0]];

// $d = sqrt($v[0]^2 + $v[1]^2 + $v[2]^2) * sqrt($n[0]^2 + $n[1]^2 + $n[2]^2);
 $d = sqrt($v[0]*$v[0] + $v[1]*$v[1] + $v[2]*$v[2]) * sqrt($n[0]*$n[0] + $n[1]*$n[1] + $n[2]*$n[2]);
 $nu = $v[0] * $n[0] + $v[1] * $n[1] + $v[2] * $n[2];
 $answer = (abs($nu / $d)/1.5)+0.33333333;
 
 // END ANGLE FIGURER
 
// echo "\n\n" . $nu . " / " . $d . " = " . $answer;
 
// $answer = 1-$answer;

	$red=dechex(round($red*$answer));
	$grn=dechex(round($grn*$answer));
	$blu=dechex(round($blu*$answer));

/*	$red = substr($red, 0, 2);
	$grn = substr($grn, 0, 2);
	$blu = substr($blu, 0, 2);*/

	if (strlen($red)==1) $red=$red.$red;
	if (strlen($grn)==1) $grn=$grn.$grn;
	if (strlen($blu)==1) $blu=$blu.$blu;

	$return="#".$red.$grn.$blu;
// echo $return."\n";
//	$return="";

//	fwrite(STDERR,$return."\n");
	return($return);
}

//  SVG START
echo "<?xml version='1.0' encoding='UTF-8' standalone='no'?>\n<svg width='" . $options["w"] . "' height='" . $options["h"] . "' viewBox='-1 -0.01 2 0.02' version='1.1'>\n  <rect style='fill:" . $options["b"] . ";fill-opacity:1;stroke:none' x='-1' y='-1' width='2' height='2' />\n";

$wireframe = 1 / $options["w"];

for ($i = 0; $i < count($faces); $i++) {
	if (isset($options["wireframe"])) {
		echo '  <path style="fill:none;stroke:#000;stroke-width:' . $wireframe . ';stroke-linejoin:round" d="M ';	
	} else {
		echo '  <path style="fill:' . triangleshading($faces[$i]) . ';stroke:none" d="M ';
	}
	echo $faces[$i][1][0] / $faces[$i][1][2] * $options["z"] . ',';
	echo $faces[$i][1][1] / $faces[$i][1][2] * $options["z"] * -1 . ' ';
	echo $faces[$i][2][0] / $faces[$i][2][2] * $options["z"] . ',';
	echo $faces[$i][2][1] / $faces[$i][2][2] * $options["z"] * -1 . ' ';
	echo $faces[$i][3][0] / $faces[$i][3][2] * $options["z"] . ',';
	echo $faces[$i][3][1] / $faces[$i][3][2] * $options["z"] * -1 . '" />' . "\n";
}

//  SVG END
echo "</svg>\n";
?>
