<?php

require_once("InvalidCellCoordinatesException.php");

class Board{
	private $width;
	private $height;
	private $cells;

	public static function create($width, $height){
		return new Board($width, $height, self::createCells($width, $height));}

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
		$this->cells = self::createCells($this->width, $this->height);}}
