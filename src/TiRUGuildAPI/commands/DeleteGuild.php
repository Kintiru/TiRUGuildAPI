<?php
namespace TiRUGuildAPI\commands;

use TiRUGuildAPI\TiRUGuildAPI;

class DeleteGuild {
    public function execute(CommandSender $sender,string $label,array $args) {
        $guildname = (string) array_shift($args);
        $main = TiRUGuildAPI::getInstance();
        if(!$main->guild_exists($guildname)){
            $sender->sendMessage("해당 길드는 존재하지 않는 길드입니다.");
            return true;
        };
        unlink($main->getPath());
    }
}
?>