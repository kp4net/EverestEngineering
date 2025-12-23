<?php

namespace App\Services;

class DeliveryCalculator {

	public function __construct(
	private OfferManager $offerManager
	) {}

	public function calculate( Package $pkg, int $baseCost ): void {
		$pkg->deliveryCost =
			$baseCost + ( $pkg->weight * 10 ) + ( $pkg->distance * 5 );

		$pkg->discount = $this->offerManager->getDiscount(
			$pkg->offerCode,
			$pkg->distance,
			$pkg->weight,
			$pkg->deliveryCost
		);

		$pkg->totalCost = $pkg->deliveryCost - $pkg->discount;
	}

	public function calculateCost(
		int $baseCost,
		int $weight,
		int $distance,
		string $offerCode
	): array {
		$deliveryCost = $baseCost + ( $weight * 10 ) + ( $distance * 5 );

		$discount = $this->offerManager->getDiscount(
			$offerCode,
			$distance,
			$weight,
			$deliveryCost
		);

		return array(
			'delivery_cost' => $deliveryCost,
			'discount'      => $discount,
			'total_cost'    => $deliveryCost - $discount,
		);
	}
}
