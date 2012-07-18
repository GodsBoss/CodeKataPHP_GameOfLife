<?php

require_once("Board.php");
require_once("InvalidCellCoordinatesException.php");

class ConwayTest extends PHPUnit_Framework_TestCase{

	public function testBoardHasASize(){
		$this->givenBoardWithSize(5, 3);
		$this->thenBoardHasSize(5, 3);}

	public function testInitiallyCellsAreDeadOnAFreshBoard(){
		$this->givenBoardWithSize(4, 3);
		$this->thenAllCellsAreDead();}

	public function testBringingCellToLife(){
		$this->givenBoardWithSize(5, 5);
		$this->whenCellIsBroughtToLifeAt(2, 3);
		$this->thenCellIsAliveAt(2, 3);}

	/**
	* @dataProvider invalidCellCoordinates
	*/
	public function testTryingToAccessCellOutsideTheBoard($width, $height, $column, $row){
		$this->givenBoardWithSize($width, $height);
		$this->whenTryingToCheckIfCellIsAliveAt($column, $row);
		$this->thenSignalInvalidCellCoordinates($column, $row);}

	/**
	* @dataProvider invalidCellCoordinates
	*/
	public function testTryingToBringCellsToLifeOutsideTheBoard($width, $height, $column, $row){
		$this->givenBoardWithSize($width, $height);
		$this->whenTryingToBringCellToLifeAt($column, $row);
		$this->thenSignalInvalidCellCoordinates($column, $row);}

	/**
	* @dataProvider invalidCellCoordinates
	*/
	public function testTryingToKillCellsOutsideTheBoard($width, $height, $column, $row){
		$this->givenBoardWithSize($width, $height);
		$this->whenTryingToKillCellAt($column, $row);
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

	private function thenAllCellsAreDead(){
		for($column = 0; $column < $this->board->getWidth(); $column++){
			for($row = 0; $row < $this->board->getHeight(); $row++){
				$this->assertTrue($this->board->isAlive($column, $row) === FALSE);}}}

	private function thenCellIsAliveAt($column, $row){
		$this->assertTrue($this->board->isAlive($column, $row));}

	private function givenBoardWithSize($width, $height){
		$this->board = Board::create($width, $height);}

	private function whenTryingToCheckIfCellIsAliveAt($column, $row){
		try{
			$this->board->isAlive($column, $row);}
		catch(Exception $exception){
			$this->exception = $exception;}}

	private function whenTryingToBringCellToLifeAt($column, $row){
		try{
			$this->board->bringToLife($column, $row);}
		catch(Exception $exception){
			$this->exception = $exception;}}

	private function whenTryingToKillCellAt($column, $row){
		try{
			$this->board->kill($column, $row);}
		catch(Exception $exception){
			$this->exception = $exception;}}

	private function whenCellIsBroughtToLifeAt($column, $row){
		$this->board->bringToLife($column, $row);}

	private $board;
	private $exception;}
