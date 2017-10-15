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

use sofe\everydb\types\Schema;

class ObjectColumn extends Column{
	/** @var Schema */
	private $schema;

	public function __construct(string $name, Schema $schema){
		parent::__construct($name);
		$this->schema = $schema;
	}

	public function getSchema() : Schema{
		return $this->schema;
	}
}
