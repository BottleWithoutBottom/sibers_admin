<?
namespace App\Core;


class Helper {
    public static function stripTags($value) {
        return htmlspecialchars(strip_tags($value));
    }

    public static function stripTagsArray($params) {
        $paramsToPrepare = $params;

        return array_map(function($item) {
            return static::stripTags($item);
        }, $paramsToPrepare);
    }
}