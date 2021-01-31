<?
namespace App\Core;


class Helper {
    public static function stripTags($value) {
        return htmlspecialchars(strip_tags($value));
    }
}