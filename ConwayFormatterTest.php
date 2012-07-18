<?php

require_once("Board.php");
require_once("Formatter.php");

class ConwayFormatterTest extends PHPUnit_Framework_TestCase{

	public function testEmptyBoard(){
		$this->givenEmpty6x4Board();
		$this->givenFormatter();
		$this->whenBoardIsFormatted();
		$this->thenShowEmpty6x4Board();}

	public function thenShowEmpty6x4Board(){
		$this->assertEquals(
			"......\n" .
			"......\n" .
			"......\n" .
			"......\n",
			$this->output);}

	public function givenEmpty6x4Board(){
		$this->board = $this->getMock('Board');
		$this->board
			->expects($this->any())
			->method('getWidth')
			->will($this->returnValue(6));
		$this->board
			->expects($this->any())
			->method('getHeight')
			->will($this->returnValue(4));
		$this->board
			->expects($this->any())
			->method('isAlive')
			->will($this->returnValue(FALSE));}

	public function givenFormatter(){
		$this->formatter = new Formatter($this->board);}

	public function whenBoardIsFormatted(){
		$this->output = $this->formatter->format($this->board);}

	private $board;
	private $formatter;
	private $output;}
