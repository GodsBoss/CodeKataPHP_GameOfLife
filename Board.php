<?php

interface Board{
	public function getWidth();
	public function getHeight();

	public function isAlive($column, $row);

	public function bringToLife($column, $row);
	public function kill($column, $row);

	public function tick();}
