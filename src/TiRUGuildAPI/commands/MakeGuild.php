<?php
namespace TiRUGuildAPI\commands;

use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use TiRUGuildAPI\TiRUGuildAPI;

class MakeGuild extends Command
{

    public function __consturct(string $name)
    {
        parent::__construct($name,
            "", 
            "" 
        );
        
        $this->setPermission("tiruguildapi.command.makeguild.player");
    }

    public function execute(CommandSender $sender, string $label, array $args)
    {
        $guildname = (string) array_shift($args);
        $main = TiRUGuildAPI::getInstance();
        
        if ($main->guildExists($guildname)) {
            $sender->sendMessage("해당 길드 이름은 이미 존재합니다! 길드 이름을 바꾸고 다시 시도해주세요!");
            return true;
        }
        $content = array(
            TiRUGuildAPI::MASTER => $sender->getName()
        );
        file_put_contents($main->getPath() . strtolower($guildname) . ".json", json_encode($content));
        $sender->sendMessage($guildname . " 길드가 성공적으로 생성되었어요!");
        
        return true;
    }
}
?>