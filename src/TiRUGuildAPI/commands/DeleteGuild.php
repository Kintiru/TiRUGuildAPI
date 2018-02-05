<?php
namespace TiRUGuildAPI\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use TiRUGuildAPI\TiRUGuildAPI;

class DeleteGuild extends Command {
    public function __construct(string $name) {
        parent::__construct(
            $name,
            "%tiruguildapi.command.deleteguild.description",
            "%tiruguildapi.command.deleteguild.usage"
        );
        $this->setPermission("tiruguildapi.command.deleteguild.player");
    }

    public function execute(CommandSender $sender,string $label,array $args) {
        $guildname = array_shift($args);
        $main = TiRUGuildAPI::getInstance();
        if(!$main->guildExists($guildname)){
            $sender->sendMessage("해당 길드는 존재하지 않는 길드입니다.");
            return true;
        };
        unlink($main->getPath());
    }
}
?>