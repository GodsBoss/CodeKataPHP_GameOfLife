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

	public function isAlive(){
		throw new InvalidCellCoordinatesException();}}
