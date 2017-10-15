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

class VirtualTypeReference extends Column implements Virtual{
	/** @var string */
	private $schemaVersion;
	/** @var string */
	private $type;

	public function __construct(string $name, string $schemaVersion, string $type){
		parent::__construct($name);
		$this->schemaVersion = $schemaVersion;
		$this->type = $type;
	}

	public function getType() : string{
		return $this->type;
	}

	public function refer() : Column{
		$schema = Schema::get($this->schemaVersion, $this->type);
		if($schema === null){
			throw new \InvalidArgumentException("Undefined schema \"$this->type\" (v{$this->schemaVersion})");
		}
		return new ObjectColumn($this->getName(), $schema);
	}
}
