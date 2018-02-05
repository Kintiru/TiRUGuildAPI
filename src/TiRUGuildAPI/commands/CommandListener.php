<?php
namespace TiRUGuildAPI\commands;

use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;

class CommandListener implements CommandExecutor {
    
    protected $owner;

    const ADD_GUILD = 1;
    const BANISH_MEMBER = 2;
    const DELETE_GUILD = 3;
    const GUILD_LIST = 4;
    const GUILD_MEMBER_LIST = 5;
    const MAKE_GUILD = 6;
    const SET_GUILD_MASTER = 7;
    
    public function __construct(Plugin $owner) {
        $this->owner = $owner;
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        $commandname = array_shift($args);

        switch () {
            case self::ADD_GUILD :
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

            default :
                break;
        }
        return true;
    }
}
?>