<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class LocaleSwitcherComponent extends Component
{

    public function currentRouteWithLocale(string $locale): string
    {
        $updatedRoute = Route::current();

        if ($updatedRoute->uri === "/") {
            $updatedRoute->uri = "{localeSwitch}";
        }

        $updatedRoute->parameters["localeSwitch"] = $locale;

        return app("url")->toRoute(
            $updatedRoute,
            $updatedRoute->parameters,
            true
        );
    }

    public function render()
    {
        return view("components.locale-switch-component");
    }
}
