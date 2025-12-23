<?php

namespace App\Services;

class Offer {

	public function __construct(
	public string $code,
	public float $discount,
	public int $minDistance,
	public int $maxDistance,
	public int $minWeight,
	public int $maxWeight
	) {}

	public function isApplicable( int $distance, int $weight ): bool {
		return $distance >= $this->minDistance &&
			   $distance <= $this->maxDistance &&
			   $weight >= $this->minWeight &&
			   $weight <= $this->maxWeight;
	}

	public function discount( string $code, float $cost, float $weight, float $distance ): float {
		$offers = config( 'offers' );

		if ( ! isset( $offers[ $code ] ) ) {
			return 0;
		}

		$o = $offers[ $code ];

		if (
			$distance >= $o['min_distance'] &&
			$distance <= $o['max_distance'] &&
			$weight >= $o['min_weight'] &&
			$weight <= $o['max_weight']
		) {
			return ( $o['discount'] / 100 ) * $cost;
		}

		return 0;
	}
}
