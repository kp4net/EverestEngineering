<?php

namespace App\Services;

class Package {

	public float $deliveryCost = 0;
	public float $discount     = 0;
	public float $totalCost    = 0;
	public float $deliveryTime = 0;

	public function __construct(
	public string $id,
	public int $weight,
	public int $distance,
	public string $offerCode
	) {}
}
