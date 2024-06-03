<?php

namespace Restugedepurnama\Furni\Domain;

class Product
{
    public int $id;
    public string $name;
    public string $price;
    public string $image;
    public User $owner;
}