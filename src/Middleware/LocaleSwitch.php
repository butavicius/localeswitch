<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use TypeError;

class LocaleSwitch
{

    /**
     * Get locale from URL or session and save it as default for constructing
     * URLs with {localeSwitch} element. Save locale to current state and
     * session for correct page translation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        $locale = $this->resolvedLocale($request);

        if ($this->isNotAvailable($locale)) {
            //TODO Throw exception
            abort(404, "Language $locale not available");
        }

        $this->saveLocale($request, $locale);

        View::share("localesAvailable", $this->localesAvailable());

        return $next($request);
    }

    private function resolvedLocale(Request $request): string
    {
        $localeParameter = $request->route("localeSwitch");

        /*
         * We expect $localeParameter to be of type string, indicating URL local
         * segment. If it is object, it most likely was implicitly bound to some
         * Model by previous middleware. See
         * https://github.com/laravel/framework/issues/34342
         *
         * Please do not use $localeSwitch variable in route controller
         * signatures, as it is reserved for Locale Switch package.
         */


        if (is_object($localeParameter)) {
            throw new TypeError(
                sprintf(
                    "Route parameter 'localeSwitch' incorrect (expected
                    string, got %s). Make sure you don't use \$localeSwitch
                    parameter in route callback method definitions.",
                    gettype($localeParameter)
                )
            );
        }

        return $request->route("localeSwitch") ??
            ($request->session()->get("localeSwitch") ?? config("app.locale"));
    }

    private function localesAvailable(): array
    {
        return ["en", "lt"];
    }

    private function saveLocale(Request $request, string $locale): void
    {
        App::setLocale($locale);
        $request->session()->put("localeSwitch", $locale);
        URL::defaults(["localeSwitch" => $locale]);
    }

    private function isNotAvailable(string $locale): bool
    {
        return !in_array($locale, $this->localesAvailable());
    }

}
