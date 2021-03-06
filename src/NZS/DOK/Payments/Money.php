<?php /** @noinspection PhpDeprecationInspection */

namespace NZS\DOK\Payments;

use _64FF00\PurePerms\PurePerms;
use JetBrains\PhpStorm\Pure;
use NZS\DOK\Main;
use NZS\DOK\UI\UIform;
use onebone\economyapi\EconomyAPI;
use onebone\pointapi\PointAPI;
use pocketmine\Player;
use jojoe7777\FormAPI;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class Money
{
    public UIform $UIform;
    public EconomyAPI $EconomyAPI;
    public PurePerms $pp;

    private static mixed $instance = null;

    /**
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->Money($player);
    }

    public static function getInstance()
    {
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

    public function getEconomyAPI(): Plugin
    {
        $API = Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
        return $API;
    }

    #[Pure] public function getForm(): UIform
    {
        return UIform::getInstance();
    }

    public function onPurePerms(): Plugin
    {
        $pure = Server::getInstance()->getPluginManager()->getPlugin("PurePerms");
        return $pure;
    }

    public function getRankName(Player $player)
    {
        return $this->onPurePerms()->getUserDataMgr()->getGroup($player)->getName();
    }

    public function Money($player)
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createSimpleForm(function (Player $player, $data) {
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch ($data) {
                case 0:
                    $this->getForm()->formOpen($player);
                    break;
                case 1:
                    $this->level1($player);
                    break;
                case 2:
                    $this->level2($player);
                    break;
                case 3:
                    $this->level3($player);
                    break;
                case 4:
                    $this->level4($player);
                    break;
                case 5:
                    $this->level5($player);
                    break;
                case 6:
                    $this->level6($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI"));
        $f->setContent($this->getMain()->getServer()->getMotd() . "Ch???n rank k??? ti???p");
        $f->addButton($this->getMain()->getCfs()->getRs("Button.exit"), 0, $this->getMain()->getCfs()->getRs("URL.IMAGE.EXIT"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Rank.Civilian"), 1, $this->getMain()->getCfs()->getRs("URL.IMAGE.RANK.1"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Rank.Soldiers"), 2, $this->getMain()->getCfs()->getRs("URL.IMAGE.RANK.2"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Rank.LandLords"), 3, $this->getMain()->getCfs()->getRs("URL.IMAGE.RANK.3"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Rank.Warden"), 4, $this->getMain()->getCfs()->getRs("URL.IMAGE.RANK.4"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Rank.Captain"), 5, $this->getMain()->getCfs()->getRs("URL.IMAGE.RANK.5"));
        $f->addButton($this->getMain()->getCfs()->getRs("Button.Rank.General"), 6, $this->getMain()->getCfs()->getRs("URL.IMAGE.RANK.6"));
        $f->sendToPlayer($player);
    }

    private function level1(Player $player) // Civilian
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(function (Player $player, $data) {
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch ($data) {
                case 1:
                    $rank = $this->getRankName($player);
                    //$lvs = $this->getMain()->getCfs()->getLevelConfig($player);
                    if ($rank == "Civilian" || $rank == "Soldiers" || "LandLord" || $rank == "Warden" || $rank == "Captain" || $rank == "General" || $rank == "Kings") {
                        $player->sendMessage(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Invalid.Message"));
                    } else {
                        $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Coin.Rank.Civilian"));
                        $player->sendMessage($this->getMain()->getCfs()->getRs("title.UI") . "??b Taken??c " . $this->getMain()->getCfs()->getRs("Cost.Coin.Rank.Civilian") . "??b From your vault!");
                        $this->onPurePerms()->setGroup($player, "Civilian");
                        $this->getMain()->getCfs()->setCfs($player->getName(), "Civilian", 1);
                    }
                    break;
                case 2:
                    //$this->getForm()->formOpen($player);
                    $this->Money($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI.Money"));
        $f->setContent(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Content.Money"));
        $f->setButton1("Buy");
        $f->setButton2("Back");
        $f->sendToPlayer($player);
    }

    private function level2(Player $player) // Soldiers
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(function (Player $player, $data) {
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch ($data) {
                case 1:
                    $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Money.Rank.Soldiers"));
                    $rank = $this->getRankName($player);
                    //$lvs = $this->getMain()->getCfs()->getLevelConfig($player);
                    if ($rank == "Soldiers" || $rank == "LandLord" || $rank == "Warden" || $rank == "Captain" || $rank == "General" || $rank == "Kings")
                    {
                        $player->sendMessage(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Invalid.Message"));
                    } else {
                        $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Coin.Rank.Civilian"));
                        $player->sendMessage($this->getMain()->getCfs()->getRs("title.UI") . "??b Taken??c " . $this->getMain()->getCfs()->getRs("Cost.Coin.Rank.Civilian") . "??b From your vault!");
                        $this->onPurePerms()->setGroup($player, "Soldiers");
                        $this->getMain()->getCfs()->setCfs($player->getName(), "Soldiers", 1);
                    }
                    break;
                case 2:
                    //$this->getForm()->formOpen($player);
                    $this->Money($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI.Money"));
        $f->setContent(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Content.Money"));
        $f->setButton1("Buy");
        $f->setButton2("Back");
        $f->sendToPlayer($player);
    }

    private function level3(Player $player) // LandLords
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(function (Player $player, $data) {
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch ($data) {
                case 1:
                    $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Money.Rank.LandLords"));
                    $rank = $this->getRankName($player);
                    //$lvs = $this->getMain()->getCfs()->getLevelConfig($player);
                    if ($rank == "Civilian" || $rank == "LandLord" || $rank == "Warden" || $rank == "Captain" || $rank == "General" || $rank == "Kings")
                    {
                        $player->sendMessage(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Invalid.Message"));
                    } else {
                        $player->sendMessage(Server::getInstance()->getMotd() . "??b Taken??c " . $this->getMain()->getCfs()->getRs("Cost.Money.Rank.LandLords") . "??b From your vault!");
                        //$pp->setGroup($player, "villager");
                        $this->getMain()->getCfs()->setCfs($player->getName(), "LandLord", 3);
                        $this->onPurePerms()->setGroup($player, "LandLord");
                    }
                    break;
                case 2:
                    //$this->getForm()->formOpen($player);
                    $this->Money($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI.Money"));
        $f->setContent(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Content.Money"));
        $f->setButton1("Buy");
        $f->setButton2("Back");
        $f->sendToPlayer($player);
    }

    private function level4(Player $player) // Warden
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(Function (Player $player, $data){
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch($data){
                case 1:
                    $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Money.Rank.Warden"));
                    $rank = $this->getRankName($player);
                    //$lvs = $this->getMain()->getCfs()->getLevelConfig($player);
                    if ($rank == "Soldiers" || $rank == "Warden" || $rank == "Captain" || $rank == "General" || $rank == "Kings"){
                        $player->sendMessage(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Invalid.Message"));
                    }else{
                        $player->sendMessage(Server::getInstance()->getMotd() . "??b Taken??c " . $this->getMain()->getCfs()->getRs("Cost.Money.Rank.Warden") . "??b From your vault!");
                        //$pp->setGroup($player, "villager");
                        $this->getMain()->getCfs()->setCfs($player->getName(), "Warden", 4);
                        $this->onPurePerms()->setGroup($player, "Warden");
                    }
                    break;
                case 2:
                    //$this->getForm()->formOpen($player);
                    $this->Money($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI.Money"));
        $f->setContent(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Content.Money"));
        $f->setButton1("Buy");
        $f->setButton2("Back");
        $f->sendToPlayer($player);
    }

    private function level5(Player $player) // Captain
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(Function (Player $player, $data){
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch($data){
                case 1:
                    $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Money.Rank.Captain"));
                    $rank = $this->getRankName($player);
                    //$lvs = $this->getMain()->getCfs()->getLevelConfig($player);
                    if ($rank == "Soldiers" || $rank == "LandLord" || $rank == "Captain" || $rank == "General" || $rank == "Kings"){
                        $player->sendMessage(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Invalid.Message"));
                    }else{
                        $player->sendMessage(Server::getInstance()->getMotd() . "??b Taken??c " . $this->getMain()->getCfs()->getRs("Cost.Money.Rank.Captain") . "??b From your vault!");
                        //$pp->setGroup($player, "villager");
                        $this->getMain()->getCfs()->setCfs($player->getName(), "Captain", 5);
                        $this->onPurePerms()->setGroup($player, "Captain");
                    }
                    break;
                case 2:
                    //$this->getForm()->formOpen($player);
                    $this->Money($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI.Money"));
        $f->setContent(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Content.Money"));
        $f->setButton1("Buy");
        $f->setButton2("Back");
        $f->sendToPlayer($player);
    }

    private function level6(Player $player)
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(Function (Player $player, $data){
            if ($data == null) {
                return $this->getForm()->formOpen($player);
            }

            switch($data){
                case 1:
                    $this->getEconomyAPI()->reduceMoney($player->getName(), $this->getMain()->getCfs()->getRs("Cost.Money.Rank.General"));
                    $rank = $this->getRankName($player);
                    //$lvs = $this->getMain()->getCfs()->getLevelConfig($player);
                    if ($rank == "Soldiers" || $rank == "LandLord" || $rank == "Warden" || $rank == "General" || $rank == "Kings"){
                        $player->sendMessage(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Invalid.Message"));
                    }else{
                        $player->sendMessage(Server::getInstance()->getMotd() . "??b Taken??c " . $this->getMain()->getCfs()->getRs("Cost.Money.Rank.General") . "??b From your vault!");
                        //$pp->setGroup($player, "villager");
                        $this->getMain()->getCfs()->setCfs($player->getName(), "General", 6);
                        $this->onPurePerms()->setGroup($player, "General");
                    }
                    break;
                case 2:
                    //$this->getForm()->formOpen($player);
                    $this->Money($player);
                    break;
            }
        });
        $f->setTitle($this->getMain()->getCfs()->getRs("title.UI.Money"));
        $f->setContent(Server::getInstance()->getMotd() . $this->getMain()->getCfs()->getRs("Content.Money"));
        $f->setButton1("Buy");
        $f->setButton2("Back");
        $f->sendToPlayer($player);
    }

}