<?php

declare(strict_types=1);

namespace NZS\DOK;

use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\Player;

class Configs
{
    //public Config $config;

    public Config $config;
    /**
     * @var mixed[]|string[]
     */
    private array $cfsAll;
    //private Config $rs;
    private Config $rs;

    public function __construct()
    {
        // By NZS
    }

    public function open(){
        $this->config = new Config($this->getMain()->getDataFolder() . "Rank.yml", Config::YAML);
        $this->cfsAll = $this->config->getAll();
        $this->getMain()->saveResource("Resources.yml");
        $this->rs = new Config($this->getMain()->getDataFolder() . "Resources.yml", Config::YAML);
    }

    public function getMain(): ?Main
    {
        $main = Server::getInstance()->getPluginManager()->getPlugin("RankDOK");
        if ($main instanceof Main){
            return $main;
        }
        return null;
    }

    public function save(){
        $this->config->save();
    }

    public function setCfs($player, $rank, int $level){
        $this->config->set($player, ["Rank" => $rank, "Level" => $level]);
        $this->config->save();
    }

    public function getLevelConfig(Player $player)
    {
        $lv = $this->config->get($player->getName())["Level"];
        return $lv;
    }

    public function getRank(Player $player)
    {
        return $this->config->get($player->getName())["Rank"];
    }

    public function getRs(String $str){
        return $this->rs->get($str);
    }

    /**public function removeCfs(Player $player): void{
        unset($this->config[$player->getName()]["Name Rank", "Level"]);
    }*/
}