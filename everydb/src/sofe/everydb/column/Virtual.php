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

interface Virtual{
	public function refer() : Column;

	public function getType() : string;
}
