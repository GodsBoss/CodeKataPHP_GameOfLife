<?php

require_once("Board.php");
require_once("Formatter.php");

class ConwayFormatterTest extends PHPUnit_Framework_TestCase{

	public function testEmptyBoard(){
		$this->givenEmpty6x4Board();
		$this->givenFormatter();
		$this->whenBoardIsFormatted();
		$this->thenShowEmpty6x4Board();}

	public function testBoardWithLivingCells(){
		$this->givenBoardWithSomeLivingCells();
		$this->givenFormatter();
		$this->whenBoardIsFormatted();
		$this->thenDisplayShowsBoardWithSomeLivingCells();}

	public function thenShowEmpty6x4Board(){
		$this->assertEquals(
			"......\n" .
			"......\n" .
			"......\n" .
			"......\n",
			$this->output);}

	public function thenDisplayShowsBoardWithSomeLivingCells(){
		$this->assertEquals($this->someLivingCellsOutput(), $this->output);}

	private function someLivingCellsOutput(){
		return
			"..O...\n" .
			"O.O...\n" .
			".O...O\n";}

	public function givenEmpty6x4Board(){
		$this->mockBoard(6, 4, $this->returnValue(FALSE));}

	public function givenBoardWithSomeLivingCells(){
		$this->mockBoard(
			count(self::$someLivingCells[0]), 
			count(self::$someLivingCells),
			$this->returnCallback(
				function($column, $row){
					return self::$someLivingCells[$row][$column];}));}

	private function mockBoard($width, $height, $isAliveResult){
		$this->board = $this->getMock('Board');
		$this->board
			->expects($this->any())
			->method('getWidth')
			->will($this->returnValue($width));
		$this->board
			->expects($this->any())
			->method('getHeight')
			->will($this->returnValue($height));
		$this->board
			->expects($this->any())
			->method('isAlive')
			->will($isAliveResult);}

	private static $someLivingCells = [
		[0, 0, 1, 0, 0, 0],
		[1, 0, 1, 0, 0, 0],
		[0, 1, 0, 0, 0, 1]];

	public function givenFormatter(){
		$this->formatter = new Formatter($this->board);}

	public function whenBoardIsFormatted(){
		$this->output = $this->formatter->format($this->board);}

	private $board;
	private $formatter;
	private $output;}
