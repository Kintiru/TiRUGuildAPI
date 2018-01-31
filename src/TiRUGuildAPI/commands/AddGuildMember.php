<?php 
namespace TiRUGuildAPI\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use TiRUGuildAPI\TiRUGuildAPI;

class AddGuildMember extends Command {
    public function __construct(string $name) {
        parent::__construct(
            $name,
            "", //Todo: 추가바람.
            ""
        );
        $this->setPermission("tiruguildapi.command.addguildmember");
    }
    
    public function execute(CommandSender $sender, string $label, array $args) {
        TiRUGuildAPI::getInstance()->addGuildMember($guildname, $player);
    }
?>