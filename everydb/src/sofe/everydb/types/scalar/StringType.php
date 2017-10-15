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

class StringType extends ScalarType{
	/** @var bool */
	private $fixed;
	/** @var bool */
	private $binary;
	/** @var int */
	private $size;
//	private $caseSensitive = true;

	/**
	 * @param bool     $fixed
	 * @param bool     $binary
	 * @param string[] $args
	 */
	public function __construct(bool $fixed, bool $binary, array $args){
		$this->fixed = $fixed;
		$this->binary = $binary;
//		if(!isset($args[0]) || !is_numeric($args[0])){
//			throw new \InvalidArgumentException("String types should follow a maximum size constraint");
//		}
		$this->size = (int) ($args[0] ?? 256);
//		if(isset($args[1]) && $args[1] === "i"){
//			$this->caseSensitive = false;
//		}
		parent::__construct(($binary ? "byte" : "char") . ($fixed ? "Array" : "Sequence") . $this->size
//			. ($this->caseSensitive ? "" : "i")
		);
	}

	public function isFixed() : bool{
		return $this->fixed;
	}

	public function isBinary() : bool{
		return $this->binary;
	}

	public function getSize() : int{
		return $this->size;
	}
}
