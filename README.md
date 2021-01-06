*Locale switcher for Laravel*

TODO:
Make facade or some way to get available language list.

**USAGE**

When defining routes, use `{localeSwitch}` segment to automatically add current language to URL.

**INSTALLATION  (local)**

*Step 1*

Make `vendor/simonboot` directory in Laravel's root and go there. Run `git clone git@github.com:simonboot/localeswitch.git`.

*Step 2*

Add this to laravel's composer.json:

```
  "repositories": [
    {
      "type": "path",
      "url": "vendors/simonboot/localeswitch"
    }
  ]
```
*Step 3*

run `composer require simonboot/localeswitch` from Laravel's project directory.
