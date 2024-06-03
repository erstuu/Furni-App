<?php

namespace Restugedepurnama\Furni\App;

class View
{
    public static function render(string $view, $model): void {
        require_once __DIR__ . "/../View/" . $view . ".php";
    }

    public static function redirect(string $url): void{
        header("Location: $url");
//        if(getenv("mode") != "test") {
            exit();
//        }
    }

}