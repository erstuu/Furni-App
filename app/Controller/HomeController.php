<?php

namespace Restugedepurnama\Furni\Controller;

use Restugedepurnama\Furni\App\View;

class HomeController
{
    function index()
    {
        View::render("Home/index", [
            "title" => "FurniTuu",
            "slogan" => "Jadikan rumahmu lebih nyaman dengan FurniTuu",
            "hooks" => "Kenyamanan dan keindahan rumahmu adalah prioritas kami",
            "product session" => "Dirancang sehingga anda dapat mendapatkan kenyamanan guna menunjang postur tubuh Anda.",
        ]);
    }
}