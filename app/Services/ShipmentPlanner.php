<?php

namespace App\Services;

use App\DTO\VehicleDTO;

class ShipmentPlanner {

	public function __construct(
	private array $vehicles
	) {}

	public function deliver( array $packages ): void {
		$pending = $packages;

		while ( ! empty( $pending ) ) {

			usort( $this->vehicles, fn( $a, $b) => $a->availableAt <=> $b->availableAt );
			$vehicle = $this->vehicles[0];

			$shipment = $this->selectShipment( $pending, $vehicle->maxWeight );

			$maxDistance   = max( array_map( fn( $p) => $p->distance, $shipment ) );
			$roundTripTime = ( $maxDistance * 2 ) / $vehicle->speed;

			foreach ( $shipment as $pkg ) {
				$pkg->deliveryTime = round(
					$vehicle->availableAt + ( $pkg->distance / $vehicle->speed ),
					2
				);
			}

			$vehicle->availableAt += $roundTripTime;

			$pending = array_udiff(
				$pending,
				$shipment,
				fn( $a,
				$b) => $a->id <=> $b->id
			);
		}
	}

	private function selectShipment( array $packages, int $limit ): array {
		usort( $packages, fn( $a, $b) => $b->weight <=> $a->weight );

		$selected = array();
		$total    = 0;

		foreach ( $packages as $pkg ) {
			if ( $total + $pkg->weight <= $limit ) {
				$selected[] = $pkg;
				$total     += $pkg->weight;
			}
		}

		return $selected;
	}
}
