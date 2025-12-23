<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OfferManager;
use App\Services\DeliveryCalculator;

class CostCalculatorServiceTest extends TestCase {

	public function test_delivery_cost_is_calculated_correctly() {
		$service = new DeliveryCalculator( new OfferManager() );

		$result = $service->calculateCost( 100, 10, 100, 'OFR003' );

		$this->assertEquals( 700, $result['delivery_cost'] );
		$this->assertEquals( 35, $result['discount'] );
		$this->assertEquals( 665, $result['total_cost'] );
	}
}
