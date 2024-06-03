<?php

namespace Restugedepurnama\Furni\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender() {
        View::render("Home/index", [
            "title" => "Furni."
        ]);

        $this->expectOutputRegex("[Furni.]");
        $this->expectOutputRegex("[Welcome to Furni.]");
    }
}
