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

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

class PortDataCommand extends Command implements PluginIdentifiableCommand{
	/** @var Plugin */
	private $plugin;

	public function __construct(Plugin $plugin, DataProvider $dataProvider, array $portFrom, string $commandName, string $description = "Port data using settings in portFrom in config.yml", ?string $usage = null, array $aliases = []){
		$usage = $usage ?? "/$commandName";
		parent::__construct($commandName, $description, $usage, $aliases);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		// TODO: Implement execute() method.
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin() : Plugin{
		return $this->plugin;
	}
}
