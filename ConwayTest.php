<?php

require_once("Board.php");

class ConwayTest extends PHPUnit_Framework_TestCase{

	public function testBoardHasASize(){
		$this->givenBoardWithSize(5, 3);
		$this->thenBoardHasSize(5, 3);}

	private function thenBoardHasSize($width, $height){
		$this->assertEquals($width, $this->board->getWidth());}

	private function givenBoardWithSize($width, $height){
		$this->board = Board::create($width, $height);}

	private $board;}
