<?php

namespace MainBoard;

class Board
{

	public int $boardSizeCol;
	public int $boardSizeRow;
	public int $numShips;
	public int $shipLength;
	public array $ships;

	public function __construct(){
        
		$this->boardSizeCol = 10;
		$this->boardSizeRow = 8;
		$this->numShips = 3;
		$this->shipLength = 3;

		for ($i = 0; $i < $this->numShips; $i++) {
			$locations = array();
			$hits = array();
			for ($j = 0; $j < $this->shipLength; $j++) {
				$locations[] = 0;
				$hits[] = "";
			}
			$ship = array(
				"locations" => $locations, "hits" => $hits
			);
			$this->ships[] = $ship;
		}
	}


	public function createBoard()
	{ 
		$ships=$this->generateShipLocations();

		$ships = json_encode($ships);

		include("src/view/battleship.php");
	}

	public function generateShipLocations($numShips="",$shipLength="")
	{
		if($numShips!="")  //use for testing purpose
		    $this->numShips=$numShips;
		if($shipLength!="")
		    $this->shipLength=$shipLength;

		$locations = array();
		for ($i = 0; $i < $this->numShips; $i++) {
			do {
				$locations = $this->generateShip();
			} while ($this->collision($locations));
			$this->ships[$i]['locations'] = $locations;
		}

		return $this->ships;
	}

	private function generateShip()
	{

		$direction = rand(0, 1);
		// direction 0 for vertical and 1 for horrizontal
		if ($direction === 1) {
			$row = rand(0, $this->boardSizeRow);
			$col = rand(0, $this->boardSizeCol - $this->shipLength);
		} else {
			$row = rand(0, $this->boardSizeRow - $this->shipLength);
			$col = rand(0, $this->boardSizeCol);
		}

		$newShipLocations = [];
		for ($i = 0; $i < $this->shipLength; $i++) {
			if ($direction === 1) {
				$newShipLocations[] = $row . "" . ($col + $i);
			} else {
				$newShipLocations[] = ($row + $i) . "" . $col;
			}
		}
		return $newShipLocations;
	}

	private function collision($locations)
	{
		for ($i = 0; $i < $this->numShips; $i++) {
			$ship = $this->ships[$i];
			for ($j = 0; $j < count($locations); $j++) {
				if (array_search($locations[$j], $ship['locations'])) {
					return true;
				}
			}
		}
		return false;
	}
}
