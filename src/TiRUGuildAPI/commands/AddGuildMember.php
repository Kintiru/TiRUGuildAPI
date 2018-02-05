<?php 
namespace TiRUGuildAPI\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use TiRUGuildAPI\TiRUGuildAPI;

class AddGuildMember extends Command {
    public function __construct(string $name) {
        parent::__construct(
            $name,
            "%tiruguildapi.command.addguildmember.description",
            "%tiruguildapi.command.addguildmember.usage"
        );
        $this->setPermission("tiruguildapi.command.addguildmember.player");
    }
    
    public function execute(CommandSender $sender, string $label, array $args) {
        $player = array_shift($args);
        TiRUGuildAPI::getInstance()->addGuildMember($guildname, $player);
    }
}
?>