<?php

class ShipLocationsTest extends \PHPUnit\Framework\TestCase {

    public function testLocation(){
         
 
        $createShip =new MainBoard\Board();

        $numShip=3;$shipLength=3;

        $shipLocations = $createShip->generateShipLocations($numShip,$shipLength);
 
        $this->assertCount($numShip, $shipLocations, "testArray doesn't contains ".$numShip." elements" );

        foreach($shipLocations as $key => $value){

            $this->assertArrayHasKey('locations', $value, "Array doesn't contains 'locations' as key");
            $this->assertArrayHasKey('hits', $value, "Array doesn't contains 'hits' as key");
 
            $this->assertCount($shipLength, $value['locations'], "ship doesn't have length ".$shipLength );

            $this->assertCount($shipLength, $value['hits'], "testArray doesn't have hits ".$shipLength );

        }

    }
}