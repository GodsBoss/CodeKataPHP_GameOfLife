<?php

require_once("ArrayBoard.php");
require_once("Formatter.php");

stream_set_blocking(STDIN, FALSE);

$board = ArrayBoard::createRandom(80, 23, 0.5);
$formatter = new Formatter($board);

$running = TRUE;
while($running){
	echo "\n" . ($formatter->format());
	usleep(500000);
	$board->tick();
	if (fgets(STDIN)){
		$running = FALSE;}}

echo "\n";
