<?php

namespace App\Console\Commands;

use App\Services\DeliveryCalculator;
use App\Services\OfferManager;
use Illuminate\Console\Command;

class CalculateCourierDeliveryCost extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:calculate-courier-delivery-cost {--baseCost=} {--weight=} {--distance=} {--offerCode=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle() {

		$baseCost  = $this->option( 'baseCost' );
		$weight    = $this->option( 'weight' );
		$distance  = $this->option( 'distance' );
		$offerCode = $this->option( 'offerCode' );

		if ( empty( $baseCost ) ) {
			$this->error( 'Please provide --baseCost option in input' );
			return Command::FAILURE;
		}

		if ( empty( $weight ) ) {
			$this->error( 'Please provide --weight option in input' );
			return Command::FAILURE;
		}

		if ( empty( $distance ) ) {
			$this->error( 'Please provide --distance option in input' );
			return Command::FAILURE;
		}

		if ( empty( $offerCode ) ) {
			$this->error( 'Please provide --offerCode option in input' );
			return Command::FAILURE;
		}

		$calculator = new DeliveryCalculator( new OfferManager() );

		$result = $calculator->calculateCost(
			(int) $baseCost,
			(int) $weight,
			(int) $distance,
			$offerCode
		);

		echo "Delivery Cost : {$result['delivery_cost']}\n";
		echo "Discount      : {$result['discount']}\n";
		echo "Total Cost    : {$result['total_cost']}\n";

	}
}
