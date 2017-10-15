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

namespace sofe\eg_everydb;

use pocketmine\plugin\PluginBase;
use sofe\everydb\DataProvider;
use sofe\everydb\EveryDb;

class EverydbExample extends PluginBase{
	/** @var DataProvider */
	private $provider;

	public function onEnable() : void{
		EveryDb::loadSchema(EveryDb::loadYamlResource($this, "schema-2.0.yml"));
		EveryDb::loadSchema(EveryDb::loadYamlResource($this, "schema-2.1.yml"));
		$this->provider = EveryDb::create($this->getConfig()->get("database", []));
	}
}
