<?php
namespace TiRUGuildAPI\utils;

use pocketmine\Player;

class check {

    private name = null;
    private guildinfo = null;

    function is_Master(Player $player, String $guildname) : bool {
        $this->name = $player->getName();
        return false;
    }
    function is_Manager(Player $player, String $guildname) : bool {
        $this->name = $player->getName();
        return false;
    }
    function is_Member(Player $player, String $guildname) : bool {
        $this->name = $player->getName();
        return false;
    }
}
?>