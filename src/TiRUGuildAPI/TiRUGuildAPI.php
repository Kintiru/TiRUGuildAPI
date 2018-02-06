<?php
declare(strict_types=1);

namespace TiRUGuildAPI;

use TiRUGuildAPI\commands\CommandListener;

use pocketmine\plugin\PluginBase;
use pocketmine\command\PluginCommand;
use TiRUGuildAPI\utils\lang;

class TiRUGuildAPI extends PluginBase
{
    public static $lang;

    private static $instance;
    private $hasGuildConfig;
    private $guildMoneyList;
    private $command;


    const MASTER = "Master";
    const MEMBER = "Member";

    const GUILD_DOESNT_EXISTS = "GuildDoesntExists";
    const CONTENTS_DOESNT_EXISTS = "ContentsDoesntExists";

    public function onLoad(): void {
        self::$lang = $this->getServer()->getLanguage()->getLang();
        self::$instance = $this;
    }

    public function onEnable(): void {
        @mkdir($this->getDataFolder());
        @mkdir($this->getPath());

        $tmp = fopen($this->getPath() . "hasguildlist.json", "c+");
        fclose($tmp);
        $tmp = fopen($this->getPath() . "guildmoneylist.json", "c+");
        fclose($tmp);
        unset($tmp);

        $this->hasGuildConfig = json_decode(file_get_contents($this->getPath() . "hasguildlist.json"));
        $this->guildMoneyList = json_decode(file_get_contents($this->getPath() . "guildmoneylist.json"));

        $this->command = new PluginCommand("guild", $this);
        $this->command->setExecutor(new CommandListener($this));
        $this->command->setDescription(lang::translate("command.default.description",self::$lang));
        $this->command->setUsage(lang::translate("command.default.usage",self::$lang));

        $this->getLogger()->notice("TiRUGuildAPI is enabled.");
    }

    public function onDisable()
    {
        file_put_contents($this->getPath() . "hasguildlist.json", $this->hasGuildConfig);
        file_put_contents($this->getPath() . "guildmoneylist.json", $this->guildMoneyList);
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    public function getPath(): string {
        return str_replace("\\", "/", $this->getDataFolder() . "TiRUGuild/");
    }

    public function hasGuild(string $player): bool {
        return ($this->hasGuildConfig[strtolower($player)] != false) ? true : false;
    }

    public function getRank(string $guildname, string $player): string {
        if (!$this->guildExists($guildname)) {
            return self::GUILD_DOESNT_EXISTS;
        }
        $player = strtolower($player);
        $config = $this->getGuildConfig($guildname);
        if($config[self::MASTER] == $player) {
            return self::MASTER;
        }
        return $config[$player];
    }

    public function addGuildMember(string $guildname, string $player): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $player = strtolower($player);
        $members = $this->getGuildConfig($guildname);
        if(isset($members[$player])) {
            return false;
        }
        $tmp = isset($this->hasGuildConfig[$player]);
        if($tmp) {
            if($this->hasGuildConfig[$player] == false) {
                $this->hasGuildConfig[$player] = $guildname;
            } else {
                return false;
            }
        } elseif (!$tmp) {
            $this->hasGuildConfig += array($player => $guildname);
        }
        $members += [$player => self::MEMBER];
        return ($this->saveGuildConfig($guildname, $members)) ? true : false;
    }

    public function deleteGuildMember(string $guildname, string $player): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $player = strtolower($player);
        $members = $this->getGuildConfig($guildname);
        if(!isset($members[$player])) {
            return false;
        }
        $this->hasGuildConfig[$player] = false;
        unset($members[$player]);
        return true;
    }

    public function guildExists(string $guildname): bool {
        return file_exists($this->getPath() . strtolower($guildname) . ".json");
    }

    public function getGuildConfig(string $guildname): array {
        return json_decode(file_get_contents($this->getPath() . strtolower($guildname) . ".json"));
    }
    public function getHasGuildConfig() {
        return $this->hasGuildConfig;
    }
    public function saveGuildConfig(string $guildname, array $config): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        file_put_contents($this->getPath() . strtolower($guildname) . ".json", json_encode($config));
        return true;
    }

    public function addGuildMoney(string $guildname, int $money): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $this->guildMoneyList[$guildname] += $money;
        return true;
    }

    public function takeGuildMoney(string $guildname, int $money): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $this->guildMoneyList[strtolower($guildname)] -= $money;
        return true;
    }

    public function setGuildMaster(string $guildname, string $player): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $config = $this->getGuildConfig($guildname);
        $config[self::MASTER] = strtolower($player);
        $this->saveGuildConfig($guildname, $config);
        return true;
    }

    public function makeGuild(string $guildname, string $master): bool {
        if ($this->guildExists($guildname)) {
            return false;
        }
        $guildname = strtolower($guildname);
        $guild = fopen($this->getPath() . $guildname . "json","w+");
        fwrite($guild,json_encode(array(self::MASTER => strtolower($master))));
        $this->guildMoneyList += array($guildname => 0);
        return true;
    }

    public function deleteGuild(string $guildname): bool {
        if (!$this->guildExists($guildname)) {
            return false;
        }
        $guildname = strtolower($guildname);
        foreach($this->getGuildConfig($guildname) as $player => $rank) {
            if($player == self::MASTER) {
                continue;
            }
            $this->hasGuildConfig[$player] = false;
        }
        unlink($this->getPath() . $guildname . ".json");
        unset($this->guildMoneyList[$guildname]);
        return true;
    }
}