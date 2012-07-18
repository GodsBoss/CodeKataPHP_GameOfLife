<?php

require_once("InvalidCellCoordinatesException.php");

class Board{
	private $width;
	private $height;

	public static function create($width, $height){
		return new Board($width, $height);}

	public function __construct($width, $height){
		$this->width = $width;
		$this->height = $height;}

	public function getWidth(){
		return $this->width;}

	public function getHeight(){
		return $this->height;}

	public function isAlive($column, $row){
		if ($column < 0 || $column >= $this->width || $row < 0 || $row >= $this->height){
			throw new InvalidCellCoordinatesException($column, $row);}
		return FALSE;}}
