<?php

/*
 *
 * everydb
 *
 * Copyright (C) 2017 SOFe
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace sofe\everydb\types\scalar;

use sofe\everydb\types\ScalarType;

class FloatType extends ScalarType{
	/**
	 * @var bool
	 */
	private $double;

	public function __construct(bool $double){
		parent::__construct($double ? "double" : "float");
		$this->double = $double;
	}

	public function isDouble() : bool{
		return $this->double;
	}
}
