<?php 

namespace App\Repositories\Cart;

interface CartRepository 
{
    public function all(); // Show All Item ...

    public function add($item, $qty = 1); // Add Item To Cart ...

    public function clear(); // Delete All From Cart ...
}