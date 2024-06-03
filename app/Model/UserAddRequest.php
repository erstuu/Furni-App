<?php

namespace Restugedepurnama\Furni\Model;

use Restugedepurnama\Furni\Domain\User;
class UserAddRequest
{
    public string $name;
    public int $price;
    public string $image;
    public User $owner;
}