<?php

class Formatter{
	private $board;

	public function __construct(Board $board){
		$this->board = $board;}

	public function format(){
		$result = "";
		for($row = 0; $row < $this->board->getHeight(); $row++){
			for($column = 0; $column < $this->board->getWidth(); $column++){
				$result .= ".";}
			$result .= "\n";}
		return $result;}}
