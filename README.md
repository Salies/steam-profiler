# steam-profiler

![](https://imgur.com/5di5jMw.png)

A lightweight profiler made with the Steam API.

**Tips!**

If the "most played game" information is incorrect, please try replacing the line 251 for this:
```php
$games_min = array_column(json_decode(json_encode($games->response->games), true), 'playtime_forever');
```

If the app doesn't run at all, make sure that your PHP version supports the ``Locale::getDisplayRegion`` function. If it doesn't, change line 225 to:
```php
$country = 'Country Flag';
```

https://steam-profiler.herokuapp.com/
