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

class IntegralScalarType extends ScalarType{
	private $bytes;
	private $signed = true;

	public function __construct(int $bytes, array $args){
		$this->bytes = $bytes;
		foreach($args as $arg){
			if(strtolower($arg) === "unsigned"){
				$this->signed = false;
			}
		}
		parent::__construct("int" . ($bytes * 8) . ($this->signed ? "" : "u"));
	}

	public function getBytes() : int{
		return $this->bytes;
	}

	public function isSigned() : bool{
		return $this->signed;
	}

	public function isUnsigned() : bool{
		return !$this->signed;
	}
}
