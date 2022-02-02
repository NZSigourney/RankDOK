<?php

namespace NZS\DOK\COMMANDS;

use NZS\DOK\UI\UIform;
use pocketmine\{Server, Player};
use NZS\DOK\Main;
use pocketmine\command\{Command, CommandSender};


class RankString extends Command
{
    #
    #public $plugin;
    public Main $plugin;

    private static mixed $instance = null;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;

        parent::__construct("xungvuong");
        $this->setDescription("Only for DOK, Buy rank System");
        $this->setUsage("/xungvuong");
        $this->setPermission("xungvuong.command");
    }

    public static function getInstance(){
        Return self::$instance;
    }

    public function getMain(): Main
    {
        return $this->plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        // TODO: Implement execute() method.

        if(!($sender instanceof Player)){
            Server::getInstance()->getLogger()->alert($this->getMain()->getMotd() . " Use in-game!");
            return true;
        }
        new UIform($player);
    }
}