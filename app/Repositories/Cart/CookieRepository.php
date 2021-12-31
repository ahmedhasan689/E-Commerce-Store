<?php 

namespace App\Repositories\Cart;

use Illuminate\Support\Facades\Cookie;


class CookieRepository implements CartRepository 
{

    protected $name = 'cart';

    protected $items = [];

    public function __construct()
    {
        $items = Cookie::get($this->name);
        
        if ($items) {
            $this->items = unserialize($items);
        }

        return [];
    }

    public function all()
    {
        return $this->items;
    }

    public function add($item, $qty = 1)
    {
        // return Session::push($this->key, $item);
        $items = $this->all();
        $items[] = $item;
        $this->items = $items;

        // Send Cookie With Response By ( queue )
        Cookie::queue($this->name, serialize($items), 60 * 24 * 30, '/', null, false, true); // ( name, value, Expired Date For Cookie, Path, Domain,  secure[Default->false], HTTP Only)
    }

    public function clear()
    {
        // Destory Cookie By Set The Expired Date In The Past
        Cookie::queue($this->name, '', -60);
    }

}