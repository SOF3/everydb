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

use sofe\everydb\types\scalar\BooleanType;
use sofe\everydb\types\scalar\FloatType;
use sofe\everydb\types\scalar\IntegralScalarType;
use sofe\everydb\types\scalar\StringType;

abstract class ScalarType extends Type{
	/** @var string */
	private $id;

	protected function __construct(string $id){
		$this->id = $id;
	}

	public static function get($typeName, ...$args) :?ScalarType{
		switch(strtolower($typeName)){
			case "byte":
			case "tinyint":
			case "int8":
				return new IntegralScalarType(1, $args);
			case "short":
			case "smallint":
			case "int16":
				return new IntegralScalarType(2, $args);
			case "triad":
			case "mediumint":
			case "int24":
				return new IntegralScalarType(3, $args);
			case "int":
			case "int32":
				return new IntegralScalarType(4, $args);
			case "bigint":
			case "long":
			case "int64":
				return new IntegralScalarType(8, $args);
			case "float":
				return new FloatType(false);
			case "double":
				return new FloatType(true);
			case "bit":
			case "bool":
			case "boolean":
				return new BooleanType();
			case "string":
			case "varchar":
				return new StringType(false, false, $args);
			case "fixedstring":
			case "char":
				return new StringType(false, false, $args);
			case "bytearray":
			case "varbinary":
				return new StringType(false, false, $args);
			case "fixedbytes":
			case "binary":
				return new StringType(false, false, $args);
		}
	}
}
