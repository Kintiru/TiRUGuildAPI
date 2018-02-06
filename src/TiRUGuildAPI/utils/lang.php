<?php
namespace TiRUGuildAPI\utils;

use TiRUGuildAPI\TiRUGuildAPI;

class lang {
    const ENGLISH = 0;
    const KOREAN = 1;

    public static function translate(string $message, string $lang = "eng"): mixed
    {
        $keys = explode(".", $message);
        $messages = file_get_contents(TiRUGuildAPI::getInstance()->getResource($lang . ".json"));
        if(!isset($messages)){
            return TiRUGuildAPI::CONTENTS_DOESNT_EXISTS;
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