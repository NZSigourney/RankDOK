<?php

declare(strict_types=1);

namespace NZS\DOK\Event;

use NZS\DOK\Configs;
use NZS\DOK\Main;
use pocketmine\event\Listener;
use pocketmine\{Player, Server};
use pocketmine\event\player\PlayerJoinEvent;

class JoinServer implements Listener
{
    private static $instance = null;

    public static function getInstance()
    {
        return self::$instance;
    }

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getMain(): Main
    {
        return $this->plugin;
    }

    public function getConfiguration(): Configs
    {
        return $this->getMain()->getCfs();
    }

    public function onJoin(PlayerJoinEvent $ev){
        if ($this->getConfiguration()->config->exists($ev->getPlayer()->getName())) {
            // TODO: Command Execute
        } else {
            $player = $ev->getPlayer();
            $this->getConfiguration()->setCfs($player, "Guest", 0);
            Server::getInstance()->getLogger()->debug("CREATING YAML FOR ".$player->getName()."!");
        }
    }

}