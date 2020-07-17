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
declare(strict_types=1);

namespace GodWeedZao\ChatCleaner;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as GW;
use GodWeedZao\ChatCleaner\formapi\FormAPI;
use GodWeedZao\ChatCleaner\UpdateTask;

class Cleaner extends PluginBase implements Listener {

    private static $ReasonMenu = ["Organize", "Advertising", "Improper words"];
    private static $chat = GW::BOLD. GW::DARK_RED ."C" . GW::RED . "hat" . GW::DARK_RED . "C" . GW::RED . "leaner" . GW::AQUA . " >" . GW::GREEN . "> " . GW::RESET;
    private static $resetChat = " \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n \n";
    private static $Reason = "§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a] §4C§chat§4C§cleaner §a[§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-" . "\n";

	public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->cfg = $this->getConfig();
        $this->saveDefaultConfig();
        $this->getScheduler()->scheduleRepeatingTask(new UpdateTask($this), $this->cfg->get("Timer"));
		$this->getLogger()->info(self::$chat . GW::GREEN . "Plugin Enabled");
	}

    /**
     * @param Player $player
     */

    public function openCCForm(Player $player){
        $form = (new FormAPI())->createCustomForm(function (Player $player, $data = null) {
            $res = $data;
            if($res === null) {
                return true;
            }
            $ReasonMenu = ["Organize", "Advertising", "Improper words"];
            $Reason = $ReasonMenu[$data[1]];
            $this->getServer()->broadcastmessage(self::$resetChat . self::$Reason . "              " . "§c!§5-§d=§5(§4C§chat §aWas Cleared§5)§d=§5-§c!\n" . "              §2Cleared By: §3" . $player->getName() . "\n              " . "§l§2Reason: §b" . $Reason . "\n§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-§2=§a-");
        });
        $form->setTitle("§l§4C§chat§4C§cleaner");
        $form->addLabel("§6Choose Your §bReason§6 For ClearChat.\n§6It'll Showing To Other Players!");
        $form->addDropdown("Choose Your Reason", self::$ReasonMenu);
        $form->sendToPlayer($player);
    }

    /**
     * @return bool
     */
    public function AutoCleaner() {
	    if ($this->cfg->get("Auto-Clean") === true) {
	        return $this->getServer()->broadcastmessage(self::$resetChat . self::$Reason . "   " . "§c!§5-§d=§5(§4C§chat §aWas Cleared Automatically§5)§d=§5-§c!");
        } else {
            $this->getLogger()->info(self::$chat . GW::RED . "Auto Clear Chat Is False!");
	        return false;
        }
    }

    /**
     * @param CommandSender $player
     * @param Command $command
     * @param string $label
     * @param array $args
     * @return bool
     */
	public function onCommand(CommandSender $player, Command $command, string $label, array $args) : bool{
		switch($command->getName()){
			case "cc":
			    if (!$player instanceof Player) {
			        $player->sendMessage(self::$chat . GW::RED . "Please Use This Command In Game.");
			        return true;
                }
				    if ((!$player->hasPermission("gw.clear.chat"))) {
				        $player->sendMessage(self::$chat . GW::RED . "You Dont Have Permission To Use This Command.");
                    } else {
                        $this->openCCForm($player);
                    }
				return true;
			default:
				return false;
		}
	}

	public function onDisable() : void{
		$this->getLogger()->info(self::$chat . GW::DARK_RED . "Plugin Disabled");
	}
}
