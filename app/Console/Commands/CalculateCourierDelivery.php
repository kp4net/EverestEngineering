<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\{
	Package,
	Vehicle,
	OfferManager,
	DeliveryCalculator,
	ShipmentPlanner
};
use Illuminate\Support\Facades\Log;

class CalculateCourierDelivery extends Command {

	protected $signature   = 'courier:calculate {--file=}';
	protected $description = 'Calculate courier delivery using JSON or interactive input';

	public function handle() {
		$file = $this->option( 'file' );

		if ( $file ) {
			return $this->handleJsonInput( $file );
		}

		$this->error( 'Please provide --file option with JSON input' );
		return Command::FAILURE;
	}

	private function handleJsonInput( string $filePath ): int {
		if ( ! Storage::exists( $filePath ) ) {
			$this->error( "JSON file not found: {$filePath}" );
			return Command::FAILURE;
		}

		$data = json_decode( Storage::get( $filePath ), true );

		if ( ! $data ) {
			$this->error( 'Invalid JSON format' );
			return Command::FAILURE;
		}

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

		// Output
		$this->info( "\nResult:" );
		foreach ( $packages as $pkg ) {
			$this->line(
				"{$pkg->id} {$pkg->discount} {$pkg->totalCost} {$pkg->deliveryTime}"
			);
		}

		return Command::SUCCESS;
	}
}
