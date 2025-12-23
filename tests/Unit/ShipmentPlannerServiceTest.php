<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ShipmentPlannerService;
use App\DTO\PackageDTO;
use App\Services\DeliveryCalculator;
use App\Services\OfferManager;
use App\Services\Package;
use App\Services\ShipmentPlanner;
use App\Services\Vehicle;
use Illuminate\Support\Facades\Storage;

class ShipmentPlannerServiceTest extends TestCase {

	public function test_delivery_time_is_assigned() {

		$data = json_decode( Storage::get( 'input.json' ), true );

		// Parse Input
		$baseCost = $data['base_delivery_cost'];
		$packages = array();

		foreach ( $data['packages'] as $pkg ) {
			$packages[] = new Package(
				$pkg['id'],
				$pkg['weight'],
				$pkg['distance'],
				$pkg['offer_code'] ?? ''
			);
		}

		$vehicles = array();
		for ( $i = 0; $i < $data['vehicles']['count']; $i++ ) {
			$vehicles[] = new Vehicle(
				$data['vehicles']['max_weight'],
				$data['vehicles']['speed']
			);
		}

		// Calculate Costs
		$calculator = new DeliveryCalculator( new OfferManager() );
		foreach ( $packages as $pkg ) {
			$calculator->calculate( $pkg, $baseCost );
		}

		// Plan Shipments
		$planner = new ShipmentPlanner( $vehicles );
		$planner->deliver( $packages );

		$this->assertNotEquals( 0, $packages[0]->deliveryTime );
		$this->assertNotEquals( 0, $packages[1]->deliveryTime );
	}
}
