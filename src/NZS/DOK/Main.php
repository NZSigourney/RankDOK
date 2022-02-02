<?php

declare(strict_types=1);

namespace NZS\DOK;

use NZS\DOK\COMMANDS\RankString;
use NZS\DOK\Event\JoinServer;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Main extends PluginBase{
    public Configs $cfs;

    public function onEnable(): void
    {
        $this->cfs = new Configs();
        $this->cfs->open();

        $this->getServer()->getCommandMap()->register("xungvuong", new RankString($this));
        $this->getServer()->getPluginManager()->registerEvents(new JoinServer($this), $this);
    }

    public function getCfs(): Configs
    {
        return $this->cfs;
    }

    public function onDisable(): void
    {
        $this->getCfs()->save();
    }
}