<?php

namespace App\Services;

class OfferManager {

	private array $offers;

	public function __construct() {
		$this->offers = array(
			'OFR001' => new Offer( 'OFR001', 0.10, 0, 200, 70, 200 ),
			'OFR002' => new Offer( 'OFR002', 0.07, 50, 150, 100, 250 ),
			'OFR003' => new Offer( 'OFR003', 0.05, 50, 250, 10, 150 ),
		);
	}

	public function getDiscount(
		string $code,
		int $distance,
		int $weight,
		float $cost
	): float {
		if ( ! isset( $this->offers[ $code ] ) ) {
			return 0;
		}

		$offer = $this->offers[ $code ];

		return $offer->isApplicable( $distance, $weight )
			? $cost * $offer->discount
			: 0;
	}
}
