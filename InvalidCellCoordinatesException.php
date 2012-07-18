<?php

class InvalidCellCoordinatesException extends Exception{
	private $column;
	private $row;

	public function __construct($column, $row){
		$this->column = $column;
		$this->row = $row;}

	public function getColumn(){
		return $this->column;}

	public function getRow(){
		return $this->row;}}
