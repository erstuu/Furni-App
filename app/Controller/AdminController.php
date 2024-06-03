<?php

namespace Restugedepurnama\Furni\Controller;

use Restugedepurnama\Furni\App\View;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Exception\ValidationException;
use Restugedepurnama\Furni\Model\UserAddRequest;
use Restugedepurnama\Furni\Repository\SessionRepository;
use Restugedepurnama\Furni\Repository\UserRepository;
use Restugedepurnama\Furni\Service\SessionService;
use Restugedepurnama\Furni\Service\AdminService;
use Restugedepurnama\Furni\Repository\AdminRepository;

class AdminController
{
    private SessionService $sessionService;
    private AdminService $adminService;
    private AdminRepository $adminRepository;


    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
        $this->adminRepository = new AdminRepository($connection);
        $this->adminService = new AdminService($this->adminRepository);
    }
    public function admin() {
    $userID = $this->sessionService->current();

    if($userID == null) {
        View::render("Home/index", [
            "title" => "FurniTuu",
            "slogan" => "Jadikan rumahmu lebih nyaman dengan FurniTuu",
            "hooks" => "Kenyamanan dan keindahan rumahmu adalah prioritas kami",
            "product session" => "Dirancang sehingga anda dapat mendapatkan kenyamanan guna menunjang postur tubuh Anda.",
        ]);
    } else {
        $products = $this->adminService->selectProduct();

        View::render("Admin/admin", [
            'title' => 'FurniTuu. Admin',
            'user' => $userID->name,
            'products' => $products
        ]);
    }
}

    public function postAdmin() {
        $request = new UserAddRequest();
        $request->name = $_POST['name'];
        $request->price = $_POST['price'];
        $request->image = $_POST['image'];

        $currentUser = $this->sessionService->current();

        if ($currentUser !== null) {
            $request->owner = $currentUser;
        }

        try {
            $this->adminService->insertProduct($request);
            header('Location: /admin');

        } catch(ValidationException $exception) {
            View::render("Admin/admin", [
                'title' => 'FurniTuu. Admin',
                'error' => $exception->getMessage()
            ]);
        }
    }

}