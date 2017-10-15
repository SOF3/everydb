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

namespace sofe\everydb;

use pocketmine\plugin\Plugin;
use sofe\everydb\types\Schema;

class EveryDb{
	const MODEL_VERSION = 1;

	private static $preferredSchemaVersion;

	public static function loadYamlResource(Plugin $plugin, string $file) : array{
		$fh = $plugin->getResource($file);
		$data = yaml_parse(stream_get_contents($fh));
		fclose($fh);
		return $data;
	}

	public static function loadSchema(array $schemas) : void{
		if(!isset($schemas[".thisVersion"])){
			throw new \InvalidArgumentException("Missing schema version! Please add the line \".thisVersion: 1.0\" to your schema file.");
		}
		$schemaVersion = $schemas[".thisVersion"];
		if(Schema::isVersionLoaded($schemaVersion)){
			throw new \InvalidArgumentException("Attempt to load duplicate version v{$schemaVersion}");
		}

		/** @var Schema[] $loadedSchemas */
		$loadedSchemas = [];
		foreach($schemas as $name => $schemaData){
			if($name === ".thisVersion"){
				continue;
			}
			$loadedSchemas[] = new Schema($schemaVersion, $name, $schemaData);
		}
		try{
			foreach($loadedSchemas as $schema){
				$schema->validate();
			}
		}catch(\RuntimeException $e){
			throw new \RuntimeException("Error while trying to validate schema: " . $e->getMessage());
		}

		if(version_compare(self::$preferredSchemaVersion, $schemaVersion, "<")){
			self::$preferredSchemaVersion = $schemaVersion;
		}
	}

	public static function create(array $config) : DataProvider{
		if(!isset($config["type"])){
			throw new \InvalidArgumentException("Missing \"type\" attribute in data provider settings in config.yml");
		}
		switch(strtolower($config["type"])){
			case "single":
				return new SingleYamlDataProvider($config);
			case "dir":
			case "multi":
				return new DirectoryYamlDataProvider($config);
			case "sq3":
			case "sqlite":
			case "sqlite3":
				if(!class_exists(\SQLite3::class)){
					throw new \InvalidArgumentException("Unable to find the SQLite3 extension. Please add the extension to your PHP installation (" . PHP_BINARY . "), or choose another data provider.");
				}
				return new SQLiteDataProvider($config);
			case "mysql":
			case "mysqli":
				if(!class_exists(\mysqli::class)){
					throw new \InvalidArgumentException("Unable to find the mysqli extension. Please add the extension to your PHP installation (" . PHP_BINARY . "), or choose another data provider.");
				}
				return new MySQLDataProvider($config);
			default:
				throw new \InvalidArgumentException("Unknown data provider type: \"{$config["type"]}\".");
		}
	}

	public static function port(bool $replace) : void{
		// TODO: Implement
	}
}
