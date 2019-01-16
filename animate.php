#! /usr/bin/php
<?php

$m=exec("wc -l ".$argv[1]."|sed 's/ ".$argv[1]."//g'");
exec("mkdir frames");

for ($i=4;$i<$m;$i++) {
	$j=$i-3;
	echo "\rSplitting frames: ".$j." of ".$m." = ".round($j/$m*100)."%    ";
	exec("cat ".$argv[1]." | head -n ".$i." > frames/frame".$j.".svg; echo \"</svg>\">>frames/frame".$j.".svg");
}

exec("ffmpeg -framerate 60 -i frames/frame%1d.svg frames/frame%8d.png -y; rm frames/frame*.svg -v");
exec("ffmpeg -framerate 60 -i frames/frame%8d.png frames.gif -y");
exec("ffmpeg -framerate 60 -i frames/frame%8d.png frames.mp4 -y");

?>
