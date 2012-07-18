<?php

require_once("Board.php");
require_once("InvalidCellCoordinatesException.php");

class ArrayBoard implements Board{
	private $width;
	private $height;
	private $cells;
	private $nextCells;

	public static function create($width, $height){
		return new ArrayBoard($width, $height, self::createCells($width, $height));}

	public function __construct($width, $height, $cells){
		$this->width = $width;
		$this->height = $height;
		$this->cells = $cells;}

	private static function createCells($width, $height){
		$cells = [];
		for($i=0; $i < $width * $height; $i++){
			$cells[] = FALSE;}
		return $cells;}

	public function getWidth(){
		return $this->width;}

	public function getHeight(){
		return $this->height;}

	public function isAlive($column, $row){
		$this->throwIfOutsideTheBoard($column, $row);
		return $this->cells[$this->cellIndex($column, $row)];}

	public function bringToLife($column, $row){
		$this->throwIfOutsideTheBoard($column, $row);
		$this->cells[$this->cellIndex($column, $row)] = TRUE;}

	public function kill($column, $row){
		$this->throwIfOutsideTheBoard($column, $row);
		$this->cells[$this->cellIndex($column, $row)] = FALSE;}

	private function throwIfOutsideTheBoard($column, $row){
		if ($column < 0 || $column >= $this->width || $row < 0 || $row >= $this->height){
			throw new InvalidCellCoordinatesException($column, $row);}}

	private function cellIndex($column, $row){
		return $row*$this->width + $column;}

	public function tick(){
		$this->nextCells = self::createCells($this->width, $this->height);
		$this->setNextLivingCells();
		$this->cells = $this->nextCells;}

	private function setNextLivingCells(){
		for($column=0; $column<$this->width; $column++){
			for($row=0; $row<$this->height; $row++){
				$this->setNextCellStateAt($column, $row);}}}

	private function setNextCellStateAt($column, $row){
		$livingNeighbours = $this->livingNeighbours($column, $row);
		if (($this->isAlive($column, $row) && $livingNeighbours === 2) || $livingNeighbours === 3){
			$this->nextCells[$this->cellIndex($column, $row)] = TRUE;}}

	private static $offsets = [-1, 0, 1];

	private function livingNeighbours($column, $row){
		$neighbours = 0;
		foreach(self::$offsets as $columnOffset){
			foreach(self::$offsets as $rowOffset){
				if ($this->isLivingNeighbour($column, $row, $columnOffset, $rowOffset)){
					$neighbours++;}}}
		return $neighbours;}

	private function isLivingNeighbour($column, $row, $columnOffset, $rowOffset){
		return !$this->isCellItself($columnOffset, $rowOffset) && $this->isAlive($this->column($column, $columnOffset), $this->row($row, $rowOffset));}

	private function isCellItself($columnOffset, $rowOffset){
		return $columnOffset === 0 && $rowOffset === 0;}

	private function column($column, $offset){
		return ($column+$offset+$this->width) % $this->width;}

	private function row($row, $offset){
		return ($row+$offset+$this->height) % $this->height;}}
