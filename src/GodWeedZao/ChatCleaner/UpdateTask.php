<?php

/**
========================================Clear Chat Automatically===============================
██████╗██╗  ██╗ █████╗ ████████╗   ██████╗██╗     ███████╗ █████╗ ███╗   ██╗███████╗██████╗
██╔════╝██║  ██║██╔══██╗╚══██╔══╝  ██╔════╝██║     ██╔════╝██╔══██╗████╗  ██║██╔════╝██╔══██╗
██║     ███████║███████║   ██║     ██║     ██║     █████╗  ███████║██╔██╗ ██║█████╗  ██████╔╝
██║     ██╔══██║██╔══██║   ██║     ██║     ██║     ██╔══╝  ██╔══██║██║╚██╗██║██╔══╝  ██╔══██╗
╚██████╗██║  ██║██║  ██║   ██║     ╚██████╗███████╗███████╗██║  ██║██║ ╚████║███████╗██║  ██║
╚═════╝╚═╝  ╚═╝╚═╝  ╚═╝   ╚═╝      ╚═════╝╚══════╝╚══════╝╚═╝  ╚═╝╚═╝  ╚═══╝╚══════╝╚═╝  ╚═╝
===============================================================================================
 * This is free software: You can redistribute it and/or modify!
 * This file is licensed under the  GNU Affero General Public License.(C)2020 GodWeedZao
 */

namespace GodWeedZao\ChatCleaner;

use pocketmine\scheduler\Task;

class UpdateTask extends Task {
	
	private $plugin;
	
	public function __construct(Cleaner $plugin) {
		$this->plugin = $plugin;
	}
	
	public function onRun(int $tick) {
		$this->plugin->AutoCleaner();
	}
	
}