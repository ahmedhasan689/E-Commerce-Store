<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\App;

class LangSwitcher extends Component
{   


    public $langs = [
        'ar' => 'العربية',
        'en' => 'English',
    ];

    public $locales;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->locale = App::getLocale(); // Or currentLocale
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lang-switcher');
    }
}
