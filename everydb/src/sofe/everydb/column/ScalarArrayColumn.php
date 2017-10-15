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

namespace sofe\everydb\column;

use sofe\everydb\types\ScalarType;

class ScalarArrayColumn extends Column implements ArrayColumn{
	/** @var ScalarType */
	private $type;

	public function __construct(string $name, ScalarType $type){
		parent::__construct($name);
		$this->type = $type;
	}

	public function getType() : ScalarType{
		return $this->type;
	}
}
