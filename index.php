<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Profiler
    </title>
    <script async defer src="https://buttons.github.io/buttons.js">
    </script>
    <link rel="stylesheet" href="assets/index.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://saliesbox.com/exp.png"/>
    <meta property="og:url" content="https://exp.saliesbox.com/profiler">
    <meta property="og:title" content="Salies Steam Profiler">
    <meta property="og:site_name" content="Salies Experiments">
    <meta property="og:description" content="A lightweight Steam data retriever, made with the Steam API.">
    <meta property="og:image" content="http://imgur.com/YprLcTh.png">
  </head>
  <body>
    <script>
      function error(){
        let de = document.querySelector('.error');
        let error = 'Error. Please enter a valid Steam64ID, Vanity ID or just the Profile URL<br>(e.g.: <u>http://steamcommunity.com/id/sonicsalies/</u> or <u>http://steamcommunity.com/profiles/76561198125501194</u>).';
        de.innerHTML = error;
      }
      function priva(){
        let de = document.querySelector('.error');
        let error = 'Error. The inputted profile is either private or friends-only.';
        de.innerHTML = error;
      }
      function display(){
        document.querySelector('.results').style.display = "block";
      }
    </script>
    <div class="wrapper">
      <section class="header">
        <header>
          <a href=".">
            <div style="margin-left:20px;">
              <img src="steam.png" style="margin-right:15px;float:left;">
              <div style="float:left;display: flex;align-self: center;font-size: 1.25rem;color: #dedddc;">Steam Profiler
              </div>
            </div>
          </a>
          <div style="margin-right:5px;">
            <a href=".">
              <menuitem>Home
              </menuitem>
            </a>
          <a href="https://github.com/Salies/steam-profiler">
            <menuitem>Source
            </menuitem>
          </a>
        <a href="https://developer.valvesoftware.com/wiki/Steam_Web_API">
          <menuitem>Steam API
          </menuitem>
        </a>
      <!--<menuitem>CS:GO Profiler</menuitem>-->
    </div>
    </header>
  </section>
<section class="page">
  <div class="form">
    Enter a Steam64ID, Vanity ID or Profile URL
    <form enctype="multipart/form-data" action="" method="post" >
      <input type="text" name="steamid" class="steamid">
    </form>
  </div>
  <div class="error">
  </div>
  <div class="results">
    <div style="float: left;width: 75%;">
      <img src="#" class="avatar">
      <a href="#" class="nickurl" target="_blank">
        <span class="nick">
        </span>
      </a>
      <br>
      <br>
      <img src="#" class="flag" title="">
      <span class="name">
      </span>
      <br>
      <span class="games_count">
      </span>
      <span class="desc"> games owned
      </span>
      <br>
      <span class="hours_count">
      </span>
      <span class="desc"> hours on record
      </span>
      <br>
      <span class="years">
      </span>
      <span class="desc"> years of service
      </span>
      <br>
      <div class="since">
      </div>
      <div style="margin-top: 8px;">
        <span class="on">
        </span> - 
        <span class="last">
        </span>
      </div>
    </div>
    <div style="float:right;width: 20%;">
      <div class="level">
      </div>
      <div class="ban">
        <img src="shield.png">
        <span class="vac">
          <span style="font-weight:500;">
          </span>
          <br>
        </span>
      </div>
    </div>
    <div class="most">
      <span class="mp">Most Played Game
      </span>
      <br>
      <div style="margin-top:10px">
        <img src="#" class="most_header">
        <a href="#" class="mosturl">
          <span class="most_name">
          </span>
        </a>
        <br>
        <span class="most_genre">
        </span> - 
        <span class="most_dev">
        </span>
        <div class="most_hours">
          <span class="m_hours">
          </span> hours on record
        </div>
      </div>
    </div>
  </div>
</section>
<footer>
  <div>Made with 
    <a style="color: #dedddc;font-weight:bold;text-decoration:none;" href="https://www.youtube.com/watch?v=g8GdH59yuD8" target="_blank">❤
    </a> by 
    <a style="color: #dedddc;" href="https://saliesbox.com">Salies
    </a>, using the 
    <a $
       </footer>
  </div>
  <?php
header("Access-Control-Allow-Origin: *");
$key = "awesome_key_here";
$input = $_POST['steamid'];
function morte(){
echo "<script>error();</script>";
die("morri"); //die function
}
function priva(){
echo "<script>priva();</script>";
die("morri"); //die function
}
if($input==""){
die(); //if input is blank, die - I'm not using my morte (death in portuguese) function 'cause a blank input happens when the program loads, then, an error message should not be displayed. It's not useful to show an error to the user if the i$
}
if(substr($input, 0, 29) === "http://steamcommunity.com/id/"){
$user = str_replace(array('http://steamcommunity.com/id/','/'), '',$input);
//echo "<script>console.log('$user')</script>";
}
else if(substr($input, 0, 35) === "http://steamcommunity.com/profiles/"){
$user = str_replace(array('http://steamcommunity.com/profiles/','/'), '',$input);
//echo "<script>console.log('$user')</script>";
}
else{
$user = $input;
}
//true info
if (is_numeric($user)!==true) {
$url = "http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=".$key."&vanityurl=".$user;
$idpage = file_get_contents($url);
$obj = json_decode($idpage);
if($obj->response->success!==1){
morte(); //if vanity input does not have a counterpart, die
}
$trueid = $obj->response->steamid;
}
else{
if(strlen($user)<17){
morte(); //if number input has less than 17 characters, die
}
$trueid = $user;
}
//urls
$level_url = "http://api.steampowered.com/IPlayerService/GetSteamLevel/v1/?key=".$key."&steamid=".$trueid;
$prof_url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$key."&steamids=".$trueid;
$games_url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=".$key."&steamid=".$trueid."&format=json&include_appinfo=1&include_played_free_games=1";
$bans_url = "http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key=".$key."&steamids=".$trueid;
$level = json_decode(file_get_contents($level_url))->response->player_level;
if(is_numeric($level)!==true){
morte();
}
$levar = "Level ".$level;
//profile info - organize
$prof_path = json_decode(file_get_contents($prof_url))->response->players[0];
//profile url
$prof_url = $prof_path->profileurl;
//name
$prof_name = $prof_path->personaname;
if($prof_path->communityvisibilitystate==1){
priva();
}
if(strlen($prof_name)>=22 && ctype_upper($prof_name)===true){
$prof_name = substr($prof_name, 0, 22);
}
else if(strlen($prof_name)>=29 && ctype_upper($prof_name)===false){
$prof_name = substr($prof_name, 0, 25);
}
//real name
$real_name = $prof_path->realname;
//image
$prof_img = $prof_path->avatarfull;
//country
$prof_loc = $prof_path->loccountrycode;
if($prof_loc==""){
$band = "#";
$country = "";
}
else{
$band = 'flags/4x3/'.$prof_loc.'.svg';
$country = Locale::getDisplayRegion("-".$prof_loc, 'en_uns');
}
//online?
$prof_state = $prof_path->personastate;
$states = [
"Offline",
"Online",
"Busy",
"Away",
"Snooze",
"Looking to trade",
"Looking to play"
];
$on = $states[$prof_state];
//last time
$last_time = $prof_path->lastlogoff;
$last_on = date('F',$last_time).date(' d',$last_time).", ".date('Y',$last_time);
$last = "Last online on ".$last_on;
//created account
$first_time = $prof_path->timecreated;
$first_on = date('F',$first_time).date(' d',$first_time).", ".date('Y',$first_time);
$years = date('Y') - date('Y',$first_time);
//games played
$games = json_decode(file_get_contents($games_url));
$games_count = $games->response->game_count;
//most played game
$games_min = array_column($games->response->games, 'playtime_forever');
$max = max($games_min); //finding most played game
$games_hours = intval($max / 60);
$total_hours = array_sum($games_min) / 60;
$games_ar = $games->response->games;
$j = count($games_ar);
for($i = 0; $i < $j ; $i++) { //looping to find its id
$play = $games->response->games[$i];
if($play->playtime_forever==$max){
$mostid = $play->appid;
$most_header = 'http://media.steampowered.com/steamcommunity/public/images/apps/'.$mostid.'/'.$play->img_logo_url.'.jpg';
}
};
//most played game info
$most_url = "http://store.steampowered.com/api/appdetails?appids=".$mostid;
$most = json_decode(file_get_contents($most_url));
$most_link = "http://store.steampowered.com/app/".$mostid;
$most_name = $most->$mostid->data->name;
$most_author = $most->$mostid->data->developers[0];
$most_genre = $most->$mostid->data->genres[0]->description;
$most_background = $most->$mostid->data->background;
//bans
$bans = json_decode(file_get_contents($bans_url));
$bans_vac = $bans->players[0]->VACBanned;
$bans_com = $bans->players[0]->CommunityBanned;
$bans_eco = $bans->players[0]->EconomyBan;
$safe = '';
if($bans_vac=="" && $bans_com=="" && $bans_eco=="none"){
$safe = 'good';
}
else{
$safe = 'bad';
}
echo //fuck arrays - nah, just kidding, it's just that JS arrays are kinda buggy to write in PHP
"
<script>
var nick = '$prof_name', real_name = '$real_name', flag = '$band', country = '$country', avatar = '$prof_img', games_count = $games_count, hours = $total_hours, years = $years, since = '$first_on', level = '$levar', online = '$on', last = '$last$
</script>
";
?>
  <script>
    var operators =
        [
          {
            class:".nick", type:"text", var:nick}
          ,
          {
            class:".name", type:"text", var:real_name}
          ,
          {
            class:".flag", type:"img", var:flag.toLowerCase()}
          ,
          {
            class:".avatar", type:"img", var:avatar}
          ,
          {
            class:".games_count", type:"text", var:games_count}
          ,
          {
            class:".hours_count", type:"text", var:hours.toFixed(2)}
          ,
          {
            class:".years", type:"text", var:years}
          ,
          {
            class:".since", type:"text", var:"(Member since " + since + ")"}
          ,
          {
            class:".level", type:"text", var:level}
          ,
          {
            class:".on", type:"text", var:online}
          ,
          {
            class:".last", type:"text", var:last}
          ,
          {
            class:".most_name", type:"text", var:most_name}
          ,
          {
            class:".most_header", type:"img", var:most_header}
          ,
          {
            class:".most_genre", type:"text", var:most_genre}
          ,
          {
            class:".most_dev", type:"text", var:most_dev}
          ,
          {
            class:".m_hours", type:"text", var:most_hours}
          ,
          {
            class:".nickurl", type:"link", var:player_url}
          ,
          {
            class:".mosturl", type:"link", var:most_url}
        ];
    for (i = 0; i < operators.length; i++) {
      if(operators[i].type=="text"){
        document.querySelector(operators[i].class).innerHTML = operators[i].var;
      }
      else if(operators[i].type=="img"){
        document.querySelector(operators[i].class).src = operators[i].var;
      }
      else if(operators[i].type=="link"){
        document.querySelector(operators[i].class).href = operators[i].var;
      }
    }
    //extra little things that aren't worth an array
    document.querySelector(".flag").title = country;
    document.querySelector(".page").style.backgroundImage = "url("+ most_back +")";
    //ban stuff
    banid = document.querySelector(".vac");
    bancont = document.querySelector(".ban");
    if(ban=="good"){
      bancont.style.background = "#1E6D1E";
      banid.innerHTML = '<span style="font-weight:500;">Safe Player</span><br>No bans on record';
    }
    else{
      bancont.style.background = "#6d1e1e";
      banid.innerHTML = '<span style="font-weight:500;">Unsafe Player</span><br>Bans on record';
    }
    display();
  </script>
  </body>
</html>
