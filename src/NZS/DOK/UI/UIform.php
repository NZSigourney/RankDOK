<?php

declare(strict_types=1);

namespace NZS\DOK\UI;

use NZS\DOK\Main;
use NZS\DOK\Payments\Coin;
use NZS\DOK\Payments\Money;
use pocketmine\{Player, Server};

class UIform
{
    private static mixed $instance = null;

    public function __construct(Player $player)
    {
        $this->formOpen($player);
    }

    public static function getInstance(){
        Return self::$instance;
    }

    public function getMain(): ?Main
    {
        $main = Server::getInstance()->getPluginManager()->getPlugin("RankDOK");
        if ($main instanceof Main) {
            return $main;
        }
        return null;
    }

    public function formOpen(Player $player): void
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createSimpleForm(Function (Player $player, ?array $data = null){
            $r = $data;
            switch($r){
                case 0:
                    $this->formOpen($player);
                    break;
                case 1:
                    $this->boughtRank($player);
                    break;
                case 2:
                    $this->featureRank($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.exit"), 0);
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Bought"), 1);
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Feature"), 2);
        $f->sendToPlayer($player);
    }

    private function boughtRank(Player $player)
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createSimpleForm(Function (Player $player, $data){
            $r = $data;
            if ($r == null){
                return $this->formOpen($player);
            }
            switch($r){
                case 0:
                    $this->formOpen($player);
                    break;
                case 1:
                    new Coin($player);
                    break;
                case 2:
                    new Money($player);
                    break;
                /**default:
                    throw new Exception("Data Value is null", 64);*/
            }
        });

        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI"));
        $f->setContent("§l§c•§r§a Chọn phương thức thanh toán!");
        $f->addButton($this->getMain()->getCfs()->getRs("Button.exit"), 0, $this->getMain()->getCfs()->getRs("URL.IMAGE.EXIT"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Coin"), 1, $this->getMain()->getCfs()->getRs("URL.IMAGE.COINBUY"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Money"), 2, $this->getMain()->getCfs()->getRs("URL.IMAGE.MONEYBUY"));
        $f->sendToPlayer($player);
    }

    public function featureRank(Player $player)
    {
        return $this->formOpen($player);
    }
}