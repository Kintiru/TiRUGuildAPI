<?php 
declare(strict_types=1);
namespace TiRUGuildAPI;

use pocketmine\plugin\PluginBase;

class TiRUGuildAPI extends PluginBase {
    private $hasguild_config = null;
    private $guildMoneyList = null;
    private static $instance = null;
    private $path = null;

    public static const MASTER = "Master";
    public static const MEMBER = "Member";

    public static const GUILD_DOESNT_EXISTS = "GuildDoesntExists";

    public function onLoad() {
        $this->path = $this->getDataFolder() . "TiRUGuild/";
        self::$instance = $this;
    }

    public function onEnable() : void {
        mkdir($this->getDataFolder());
        mkdir($this->getDataFolder() . "TiRUGuild");

        $this->hasguild_config = json_decode(file_get_contents($this->getPath() . "hasguildlist.json"));
        $this->guildMoneyList = json_decode(file_get_contents($this->getPath() . "guildmoneylist.json"));
        $this->getLogger()->notice("TiRUGuildAPI is enabled.");
    }

    public static function getInstance() {
        return self::$instance;
    }

    public function getPath() {
        return $this->path;
    }
    
    public function hasGuild(string $player) : bool {
        return ($this->hasguild_config[strtolower($player)] === true) ? true : false;
    }

    public function getRank(string $player, string $guildname) : string {
        if(!$this->guildExists($guildname)) {
            return self::GUILD_DOESNT_EXISTS;
        }
        $config = $this->getGuildConfig($guildname);
        return $config[strtolower($player)];
    }

    public function addGuildMember(string $guildname, string $player) : bool {
        if(!$this->guildExists($guildname)) {
            return false;
        }
        $members = $this->getGuildConfig($guildname);
        $members += [$player => self::MEMBER];
        return ($this->saveGuildConfig($guildname, $members)) ? true : false;
    }

    public function deleteGuildMember(string $guildname, string $player) : bool {
        if(!$this->guildExists($guildname)) {
            return false;
        }
    }
    public function guildExists(string $guildName) : bool {
        return file_exists($this->getPath() . strtolower($guildName) . ".json");
    }

    public function getGuildConfig (string $guildname) : array {
        return ($this->guildExists($guildname)) ? json_decode(file_get_contents($this->getPath() . strtolower($guildname) . ".json")) : [];
    }

    public function saveGuildConfig(string $guildname , array $config) : bool {
        if(!$this->guildExists($guildname)) {
            return false;
        }
        file_put_contents($this->getPath() . strtolower($guildname) . ".json", json_encode($config));
        return true;
    }
    public function addGuildMoney(string $guildname, string $money) :bool {
        if(!$this->guildExists($guildname)) {
            return false;
        }

    }

    public function takeGuildMoney(string $guildname, string $money) {
        if(!$this->guildExists($guildname)) {
            return false;
        }
        $config = $this->getGuildConfig($guildname);
    }

    public function setGuildMaster(string $guildname , string $player) {
        if(!$this->guildExists($guildname)) {
            return false;
        }
        $config = $this->getGuildConfig($guildname);
    }
    
    public function addRank() {
        
    }
    
    public function deleteRank() {
        
    }
    
    public function getRankList() {
        
    }

}
?>