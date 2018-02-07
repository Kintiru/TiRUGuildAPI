<?php
namespace TiRUGuildAPI\utils;

use TiRUGuildAPI\TiRUGuildAPI;

class lang {

    public static function translate(string $message, string $lang = "eng"): mixed
    {
        $keys = explode(".", $message);
        $messages = file_get_contents();
        if(!isset($messages)){
            return false;
        }
        $returnMessage = $messages;
        foreach($keys as $value) {
            $returnMessage = $returnMessage[$value];
        }
        return $returnMessage;
    }
}
?>
/**
 * Created by PhpStorm.
 * User: Kintiru
 * Date: 2018-02-05
 * Time: 오후 10:22
 */