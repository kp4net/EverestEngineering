<?php

namespace App\Services;

class Vehicle {

	public float $availableAt = 0;

	public function __construct(
	public int $maxWeight,
	public int $speed
	) {}
}
