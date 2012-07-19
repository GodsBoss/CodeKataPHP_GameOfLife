<?php

require_once("ArrayBoard.php");
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

	public function testKillingCells(){
		$this->givenBoardWithSize(5, 5);
		$this->whenCellIsBroughtToLifeAt(1, 4);
		$this->whenCellIsKilledAt(1, 4);
		$this->thenCellIsDeadAt(1, 4);}

	/**
	* @dataProvider boardSituationAndResult
	*/
	public function testWorldTick($cells, $isCellLivingAfterTick){
		$this->given3x3BoardWithContents($cells);
		$this->whenWorldTicks();
		$this->thenCenterCellStateIs($isCellLivingAfterTick);}

	public function boardSituationAndResult(){
		return [
			[
				[
					0,0,0,
					0,1,0,
					0,0,0],
				FALSE],
			[
				[
					0,0,0,
					1,1,0,
					0,0,0],
				FALSE],
			[
				[
					0,0,0,
					1,1,1,
					0,0,0],
				TRUE],
			[
				[
					0,1,0,
					0,1,0,
					0,1,0],
				TRUE],
			[
				[
					1,1,0,
					0,1,0,
					0,0,1],
				TRUE],
			[
				[
					0,0,1,
					1,1,0,
					1,0,0],
				TRUE],
			[
				[
					1,0,1,
					0,1,1,
					1,0,0],
				FALSE],
			[
				[
					0,1,1,
					1,1,0,
					0,1,1],
				FALSE],
			[
				[
					1,1,0,
					1,1,1,
					1,0,1],
				FALSE],
			[
				[
					0,1,1,
					1,1,1,
					1,1,1],
				FALSE],
			[
				[
					1,1,1,
					1,1,1,
					1,1,1],
				FALSE],
			[
				[
					1,0,0,
					0,0,1,
					0,1,0],
				TRUE]];}

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

	public function testCreatingRandomBoardWithLivingCellDensity(){
		$this->givenThousandBoardsWithDensity();
		$this->thenMostBoardsHaveCellDistributionNearDensity();}

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

	private function thenCellIsDeadAt($column, $row){
		$this->assertFalse($this->board->isAlive($column, $row));}

	private function thenCenterCellStateIs($state){
		$this->assertEquals($state, $this->board->isAlive(1, 1));}

	private function thenMostBoardsHaveCellDistributionNearDensity(){
		$deviations = 0;
		foreach($this->randomBoards as $boardDensityInfo){
			$board = $boardDensityInfo['board'];
			$density = $boardDensityInfo['density'];
			$livingCells = 0;
			for($column=0; $column<$board->getWidth(); $column++){
				for($row=0; $row<$board->getHeight(); $row++){
					if ($board->isAlive($column, $row)){
						$livingCells++;}}}
			if (abs($livingCells / ($board->getWidth() * $board->getHeight()) - $density) > self::$densityDeviationThreshold){
				$deviations++;}}
		$this->assertLessThan(self::$maximumAllowedDeviations, $deviations);}

	private static $densityDeviationThreshold = 0.05;
	private static $maximumAllowedDeviations = 10;

	private function givenBoardWithSize($width, $height){
		$this->board = ArrayBoard::create($width, $height);}

	private function given3x3BoardWithContents($cells){
		$this->givenBoardWithSize(3, 3);
		for($index = 0; $index < 9; $index++){
			if ($cells[$index] === 1){
				$this->board->bringToLife($index % 3, floor($index / 3));}}}

	private function givenThousandBoardsWithDensity(){
		$this->randomBoards = [];
		for($i=0; $i<1000; $i++){
			$density = $i / 1000;
			$this->randomBoards[] = [
				'density' => $density,
				'board' => ArrayBoard::createRandom(40, 25, $density)];}}

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

	private function whenCellIsKilledAt($column, $row){
		$this->board->kill($column, $row);}

	private function whenWorldTicks(){
		$this->board->tick();}

	private $board;
	private $exception;
	private $randomBoards;}
