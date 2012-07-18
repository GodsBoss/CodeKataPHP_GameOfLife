<?php

require_once("Board.php");
require_once("InvalidCellCoordinatesException.php");

class ConwayTest extends PHPUnit_Framework_TestCase{

	public function testBoardHasASize(){
		$this->givenBoardWithSize(5, 3);
		$this->thenBoardHasSize(5, 3);}

	/**
	* @dataProvider invalidCellCoordinates
	*/
	public function testTryingToAccessCellOutsideTheBoard($width, $height, $column, $row){
		$this->givenBoardWithSize($width, $height);
		$this->whenTryingToCheckIfCellIsAliveAt($column, $row);
		$this->thenSignalInvalidCellCoordinates($column, $row);}

	public function invalidCellCoordinates(){
		return [
			[3, 3, -2, 1],
			[3, 3, 5, 0],
			[3, 3, 1, -3],
			[3, 3, 2, 6]];}

	private function thenBoardHasSize($width, $height){
		$this->assertEquals($width, $this->board->getWidth());}

	private function thenSignalInvalidCellCoordinates($column, $row){
		$this->assertInstanceOf(InvalidCellCoordinatesException, $this->exception);
		$this->assertTrue($column === $this->exception->getColumn());
		$this->assertTrue($row === $this->exception->getRow());}

	private function givenBoardWithSize($width, $height){
		$this->board = Board::create($width, $height);}

	private function whenTryingToCheckIfCellIsAliveAt($column, $row){
		try{
			$this->board->isAlive($column, $row);}
		catch(Exception $exception){
			$this->exception = $exception;}}

	private $board;
	private $exception;}
