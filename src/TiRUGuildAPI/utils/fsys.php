<?php
namespace TiRUGuildAPI\utils;

use pocketmine\utils\Config;

class fsys {
    private $type = 2;
    public function getFile(String $filename) {
        
    }
    public function writeFile(String $filename) {
        $config = new Config($filename, $type);
    }
}
?>