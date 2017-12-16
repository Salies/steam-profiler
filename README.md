# steam-profiler

![](https://imgur.com/5di5jMw.png)

A lightweight profiler made with the Steam API.

**Tip!**

If the "most played game" information is incorrect, please try replacing the line 251 for this:
```php
$games_min = array_column(json_decode(json_encode($games->response->games), true), 'playtime_forever');
```

https://steam-profiler.herokuapp.com/
