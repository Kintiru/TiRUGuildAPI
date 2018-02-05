<?php
declare(strict_types=1);

namespace TiRUGuildAPI;

use TiRUGuildAPI\commands\CommandListener;

use pocketmine\plugin\PluginBase;
use pocketmine\command\PluginCommand;

class TiRUGuildAPI extends PluginBase
{
    private $hasGuildConfig = null;
    private $guildMoneyList = null;
    private $command = null;

    private static $instance = null;

    const MASTER = "Master";
    const MEMBER = "Member";
    const GUILD_DOESNT_EXISTS = "GuildDoesntExists";


    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        @mkdir($this->getDataFolder());
        @mkdir($this->getPath());

        $tmp = fopen($this->getPath() . "hasguildlist.json", "a+");
        fclose($tmp);
        $tmp = fopen($this->getPath() . "guildmoneylist.json", "a+");
        fclose($tmp);

        $this->hasGuildConfig = json_decode(file_get_contents($this->getPath() . "hasguildlist.json"));
        $this->guildMoneyList = json_decode(file_get_contents($this->getPath() . "guildmoneylist.json"));

        $this->command = new PluginCommand("guild", $this);
        $this->command->setExecutor(new CommandListener($this));
        $this->command->setDescription(); //todo : 내용 추가
        $this->command->setUsage(); //todo : 내용 추가

        $this->getLogger()->notice("TiRUGuildAPI is enabled.");
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    public function getPath(): string {
        return str_replace("\\", "/", $this->getDataFolder() . "TiRUGuild/");
    }

    public function hasGuild(string $player): bool {
        return ($this->hasGuildConfig[strtolower($player)] === true) ? true : false;
    }

    public function getRank(string $player, string $guildname): string {
        if (!$this->guildExists($guildname)) {
            return self::GUILD_DOESNT_EXISTS;
        }
        $config = $this->getGuildConfig($guildname);
        return $config[strtolower($player)];
    }

    public function addGuildMember(string $guildname, string $player): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $members = $this->getGuildConfig($guildname);
        $members += [$player => self::MEMBER];
        return ($this->saveGuildConfig($guildname, $members)) ? true : false;
    }

    public function deleteGuildMember(string $guildname, string $player): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
    }

    public function guildExists(string $guildname): bool {
        return file_exists($this->getPath() . strtolower($guildname) . ".json");
    }

    public function getGuildConfig(string $guildname): array {
        return json_decode(file_get_contents($this->getPath() . strtolower($guildname) . ".json"));
    }

    public function saveGuildConfig(string $guildname, array $config): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        file_put_contents($this->getPath() . strtolower($guildname) . ".json", json_encode($config));
        return true;
    }

    public function addGuildMoney(string $guildname, string $money): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        if (!isset($this->guildMoneyList[$guildname])) {
            return false;
        }
    }

    public function takeGuildMoney(string $guildname, string $money): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        if (!isset($this->guildMoneyList[$guildname])) {
            return false;
        }
    }

    public function setGuildMaster(string $guildname, string $player): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $config = $this->getGuildConfig($guildname);
        $config[self::MASTER] = $player;
        $this->saveGuildConfig($guildname, $config)
    }

    public function addRank(string $rank): bool {

    }

    public function deleteRank(string $rank): bool {

    }

    public function getRankList(string $guildname): array {
        if (!$this->guildExists($guildname)) {
            return false;
        }
    }

    public function makeGuild(string $guildname): bool {
        if ($this->guildExists($guildname)) {
            return false;
        }
    }

    public function deleteGuild(string $guildname): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
    }

}

?>