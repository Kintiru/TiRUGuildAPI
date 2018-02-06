<?php
namespace TiRUGuildAPI\commands;

use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;

use TiRUGuildAPI\utils\lang;
use TiRUGuildAPI\TiRUGuildAPI;

class CommandListener implements CommandExecutor {

    private $lang;
    protected $owner;

    const ERROR = -1;

    const DEFAULT = 0;
    const INVITE_MEMBER = 1;
    const BANISH_MEMBER = 2;
    const DELETE_GUILD = 3;
    const GUILD_LIST = 4;
    const GUILD_MEMBER_LIST = 5;
    const MAKE_GUILD = 6;
    const SET_GUILD_MASTER = 7;
    const ADD_GUILD_MONEY = 8;
    const TAKE_GUILD_MONEY = 9;
    const GUILD_DEPOSIT = 10;
    const GUILD_WITHDRAW = 11;
    const GUILD_REMITTANCE = 12;
    const GUILD_INFO = 13;
    
    public function __construct(Plugin $owner) {
        $this->owner = $owner;
        $this->lang = TiRUGuildAPI::$lang;
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args = [""]) : bool {
        $commandname = (string) array_shift($args);

        switch ($this->detectCommand($commandname, $this->lang)) {
            case self::INVITE_MEMBER :
                $player = (string) array_shift($args);
                $guildname = TiRUGuildAPI::getInstance()->getHasGuildConfig()[strtolower($player)]; //todo : 내용추가
                TiRUGuildAPI::getInstance()->addGuildMember($guildname,$player);
                $sender->sendMessage(lang::translate("",$this->lang));
                break;
            case self::BANISH_MEMBER :
                break;
            case self::DELETE_GUILD :
                break;
            case self::GUILD_LIST :
                break;
            case self::GUILD_MEMBER_LIST :
                break;
            case self::MAKE_GUILD :
                break;
            case self::SET_GUILD_MASTER :
                break;
            case self::ADD_GUILD_MONEY :
                break;
            case self::TAKE_GUILD_MONEY :
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
?>