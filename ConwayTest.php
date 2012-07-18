<?php

require_once("Board.php");
require_once("InvalidCellCoordinatesException.php");

class ConwayTest extends PHPUnit_Framework_TestCase{

	public function testBoardHasASize(){
		$this->givenBoardWithSize(5, 3);
		$this->thenBoardHasSize(5, 3);}

	public function testTryingToAccessCellTooFarToTheLeft(){
		$this->givenBoardWithSize(3, 2);
		$this->whenTryingToCheckIfCellIsAliveAt(-2, 1);
		$this->thenSignalInvalidCellCoordinates();}

	private function thenBoardHasSize($width, $height){
		$this->assertEquals($width, $this->board->getWidth());}

	private function thenSignalInvalidCellCoordinates(){
		$this->assertInstanceOf(InvalidCellCoordinatesException, $this->exception);}

	private function givenBoardWithSize($width, $height){
		$this->board = Board::create($width, $height);}

	private function whenTryingToCheckIfCellIsAliveAt($column, $row){
		try{
			$this->board->isAlive($column, $row);}
		catch(Exception $exception){
			$this->exception = $exception;}}

	private $board;
	private $exception;}
