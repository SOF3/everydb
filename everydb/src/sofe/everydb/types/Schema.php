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

namespace sofe\everydb\types;

use sofe\everydb\column\Column;
use sofe\everydb\column\ScalarArrayColumn;
use sofe\everydb\column\ScalarColumn;
use sofe\everydb\column\Virtual;
use sofe\everydb\column\VirtualTypeArrayReference;
use sofe\everydb\column\VirtualTypeReference;

class Schema extends Type{
	private static $schemas = [];

	public static function get(string $schemaVersion, string $typeName) :?Schema{
		return self::$schemas[$schemaVersion][$typeName] ?? null;
	}

	/** @var string */
	private $version;
	/** @var string */
	private $name;
	/** @var string[] */
	private $keyColumns;

	/** @var Column[] */
	private $columns;
	/** @var bool */
	private $valid = true;

	public function __construct(string $schemaVersion, string $schemaName, array $schema){
		$this->version = $schemaVersion;
		$this->name = $schemaName;
		self::$schemas[$schemaVersion][$schemaName] = $this;
		$this->keyColumns = (array) ($schema[".key"] ?? []);

		foreach($schema as $colName => $type){
			if($colName{0} === "."){
				continue;
			}
			$typeAttributes = explode(" ", $type);
			$typeName = array_shift($typeAttributes);
			if($isArray = (substr($typeName, -2) === "[]")){
				$typeName = substr($typeName, 0, -2);
			}
			$scalarType = ScalarType::get($typeName, ...$typeAttributes);

			if($isArray){
				if($scalarType !== null){
					$this->columns[$colName] = new ScalarArrayColumn($colName, $scalarType);
				}else{
					$this->columns[$colName] = new VirtualTypeArrayReference($colName, $schemaVersion, $typeName);
					$this->valid = false;
				}
			}else{
				if($scalarType !== null){
					$this->columns[$colName] = new ScalarColumn($colName, $scalarType);
				}else{
					$this->columns[$colName] = new VirtualTypeReference($colName, $schemaVersion, $typeName);
					$this->valid = false;
				}
			}
		}
	}

	public static function isVersionLoaded(string $schemaVersion) : bool{
		return isset(self::$schemas[$schemaVersion]);
	}

	public function validate(){
		foreach($this->columns as &$column){
			if($column instanceof Virtual){
				$column = $column->refer();
			}
		}
		unset($column);
		$this->valid = true;
	}

	public function getSchemaVersion() : string{
		return $this->version;
	}

	public function getName() : string{
		return $this->name;
	}

	public function isPrimary() : bool{
		return count($this->keyColumns) !== 0;
	}
}
