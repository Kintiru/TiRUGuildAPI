<?php 
namespace TiRUGuildAPI\commands;

use pocketmine\command\Command;

use TiRUGuildAPI;

class GuildMemberList extends Command{
    public function __construct() {

    }

    public function execute(CommandSender $sender,string $label,array $args) {
        $guildname = (string) array_shift($args);
        $main = TiRUGuildAPI::getInstance();
        if(($guildname)){
            $sender->sendMessage("해당 길드는 존재하지 않는 길드입니다.");
            return true;
        }
        $json = json_decode(file_get_contents($main->getPath() . strtolower($guildname) . ".json"));
        return true;
    }
}
?>