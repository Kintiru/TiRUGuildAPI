<?php
namespace TiRUGuildAPI\commands;

use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

use TiRUGuildAPI\utils\lang;
use TiRUGuildAPI\TiRUGuildAPI;

class CommandListener extends PluginCommand implements CommandExecutor {

    private $lang;
    protected $main;
    protected $owner;

    const ERROR = -1;

    const DEFAULT = 0;
    const INVITE = 1;
    const BANISH = 2;
    const DELETE = 3;
    const LIST = 4;
    const MEMBER_LIST = 5;
    const MAKE = 6;
    const MASTER = 7;
    const GIVEMONEY = 8;
    const TAKEMONEY = 9;
    const DEPOSIT = 10;
    const WITHDRAW = 11;
    const REMITTANCE = 12;
    const INFO = 13;
    const LEAVE = 14;
    
    public function __construct(Plugin $owner, TiRUGuildAPI $main, string $name) {
        $this->main = $main;
        $this->owner = $owner;
        $this->lang = TiRUGuildAPI::$lang;
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args = [""]) : bool {
        $commandname = (string) array_shift($args);

        switch ($this->detectCommand($commandname, $this->lang)) {
            case self::ERROR :
                break;
            case self::INVITE :
                $player = (string) array_shift($args);
                $guildname = $this->main->getHasGuildConfig()[strtolower($player)];
                $this->main->addGuildMember($guildname,$player);
                $sender->sendMessage(lang::translate("",$this->lang));
                break;
            case self::BANISH :
                break;
            case self::DELETE :
                break;
            case self::LIST :
                break;
            case self::MEMBER_LIST :
                break;
            case self::MAKE :
                break;
            case self::MASTER :
                break;
            case self::GIVEMONEY :
                break;
            case self::TAKEMONEY :
                break;
            default :
                break;
        }
        return true;
    }

    public function detectCommand(string $commandname, $lang): int {
        $config = fopen($this->owner->getResource("commands.json"),"c+");
        $guild = json_decode(fread($config, filesize($config)));
        if(!isset($guild[$lang][$commandname])) {
            return self::ERROR;
        }
        return $guild[$lang][$commandname];
    }
}