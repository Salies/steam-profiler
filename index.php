<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Steam Profiler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="index.min.css" />
</head>
<body>
<?php
$key = "your-cool-key";
//to avoid error messages
$input = '';
if(isset($_GET['id'])){
    $input = $_GET['id'];
}

function parseSteamVanity($key, $vanity){
    $data = json_decode(file_get_contents('https://api.steampowered.com/ISteamUser/ResolveVanityURL/v1/?key='.$key.'&vanityurl='.$vanity));
    if($data->response->success!==1){
        return false;
    }
    else{
        return $data->response->steamid;
    }
}

function parseSteamURL($key, $url){
    if(strrpos($url, '/id/') !== false){
        return parseSteamVanity($key, str_replace("/", "", substr($url, strpos($url, "/id/") + 4)));
    }
    else if(strrpos($url, '/profile/') !== false){
        return parseSteamVanity($key, str_replace("/", "", substr($url, strpos($url, "/profile/") + 9)));
    }
    else{
        return false;
    }
}

function parseSteamInput($key, $input){
    if(substr($input, 0, 4) == 'http'){
        return parseSteamURL($key, $input);
    }
    else if(is_numeric($input) === true && strlen($input) === 17){
        return $input;
    }
    else{
        return parseSteamVanity($key, $input);
    }
}

function printProfile($dataArray){
    $tag = '<div class="results"> <div class="player"> <div class="avatar" style="background-image:url('.$dataArray[0]->avatarfull.')"></div><a href="'.$dataArray[0]->profileurl.'" target="_blank" class="personaname">'.$dataArray[0]->personaname.'</a> <br><div class="country">'.(isset($dataArray[0]->loccountrycode) ?'<img src="node_modules/flag-icon-css/flags/4x3/'.strtolower($dataArray[0]->loccountrycode).'.svg" title="'.Locale::getDisplayRegion('-'.$dataArray[0]->loccountrycode, 'en').'">' : '').' <span>'.(isset($dataArray[0]->realname)?$dataArray[0]->realname:'').'</span> </div><span class="number">'.$dataArray[2][0].'</span> <span class="label">games owned</span> <br><span class="number">'.$dataArray[2][2].'</span> <span class="label">hours on record</span> <br><span class="number">'.(date('Y') - date('Y', $dataArray[0]->timecreated)).'</span> <span class="label">years of service</span><br><div class="since">(Member since '.date('F d, Y', $dataArray[0]->timecreated).')</div><span class="on">Online</span> - <span class="label">Last online on '.date('F d, Y', $dataArray[0]->lastlogoff).'</span> </div><div class="level-ban"> <div class="level">Level '.$dataArray[1].'</div><div class="ban'.($dataArray[3] !== 0 ? ' true' : '').'">'.($dataArray[3] === 0 ? '<b>Clean</b><br>No VAC bans on record.' : '<b>Hammered!</b><br>Has VAC bans on record.').'</b></div></div>';
    echo $tag;
    if($dataArray[2][1]!==null){
        echo '<div class="game"> <span class="most-played">Most Played Game</span> <div> <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/'.$dataArray[2][1]->appid.'/'.$dataArray[2][1]->img_logo_url.'.jpg"> <a href="http://store.steampowered.com/app/'.$dataArray[2][1]->appid.'" target="_blank" class="mosturl"><span class="game-title">'.$dataArray[2][1]->name.'</span></a> <br><span class="game-dev">'.$dataArray[2][1]->appid.'</span><br><span class="game-hours">'.number_format($dataArray[2][1]->playtime_forever / 60, 0, '', '').'</span> <span class="game-label">hours on record</span> </div></div></div><style>.container{background-image:url(https://steamcdn-a.akamaihd.net/steam/apps/'.$dataArray[2][1]->appid.'/page_bg_generated_v6b.jpg);}</style>';
    }
    return 1;
}

$url = array(
    'ISteamUser/GetPlayerSummaries/v2/?steamids=',
    'IPlayerService/GetSteamLevel/v1/?steamid=',
    'IPlayerService/GetOwnedGames/v1/?include_appinfo=1&include_played_free_games=1&steamid=',
    'ISteamUser/GetPlayerBans/v1/?steamids='
);

$data = array();
?>

<div class="wrapper">
    <div class="s-header">
    <header>
          <a href=".">
            <div class="logo-container">
              <img src="https://imgur.com/YprLcTh.png">
              <div class="logo">Steam Profiler
              </div>
            </div>
          </a>
          <div class="menu-container">
            <a href=".">
              <menuitem>Home
            </menuitem>
            </a>
          <a href="https://github.com/Salies/steam-profiler">
            <menuitem>Source
            </menuitem>
          </a>
    </div>
    </header>

    <div class="container">
        <div class="form-container">
            Enter a Steam64ID, Vanity ID or Profile URL
            <form>
                <input type="text" name="id" class="steamid">
            </form>
        </div>

        <?php
        if($input){
            $id = parseSteamInput($key, $input);
            
            if($id!==false){
                array_push($data, json_decode(file_get_contents('https://api.steampowered.com/'.$url[0].$id.'&key='.$key)));
                if($data[0]->response->players[0]->communityvisibilitystate!==3){
                    echo '<div class="error">This profile is either set to "private" or "friends only".</div>';
                    return 0;
                }

                for($i=1;$i<sizeof($url);$i++){
                    array_push($data, json_decode(file_get_contents('https://api.steampowered.com/'.$url[$i].$id.'&key='.$key)));
                }

                //filtrating info
                $data[1] = $data[1]->response->player_level;
                $data[0] = $data[0]->response->players[0];
                $data[3] = $data[3]->players[0]->NumberOfVACBans;
                $data[2] = $data[2]->response;
                if(empty((array)$data[2])){
                    $data[2] = array();
                    $data[2][0] = '–';
                    $data[2][1] = null;
                    $data[2][2] = '–';
                }
                else{
                    function cmp($a, $b)
                    {   
                        if ($a->playtime_forever == $b->playtime_forever) {
                        return 0;
                        }
                        return ($a->playtime_forever > $b->playtime_forever) ? -1 : 1;
                    }
                    usort($data[2]->games, "cmp");
                    $data[2] = array($data[2]->game_count, $data[2]->games[0], number_format(array_sum(array_column($data[2]->games, 'playtime_forever')) / 60, 2, '.', ''));
                }
            
                printProfile($data);
            }
            else{
                echo '<div class="error">This profile does not exist.</div>';
            }
        }
        ?>
    </div>

    <footer>
        Made with ❤ by Salies using the Steam API.
    </footer>
</div>
</body>
</html>