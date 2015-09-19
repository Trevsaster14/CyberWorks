<?php
function select($val, $row)
{
    if ($row == $val) {
        return 'selected';
    }
}

function nameID($pId, $db_link)
{
    $sql = "SELECT `name` FROM `players` WHERE `playerid` LIKE '" . $pId . "' ";
    $result_of_query = $db_link->query($sql);

    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            return $row['name'];
        }
    } else {
        return $pId;
    }
}

function uID($pId, $db_link)
{
    $sql = "SELECT `uid` FROM `players` WHERE `playerid` = '" . $pId . "' ";
    $result_of_query = $db_link->query($sql);
    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            return $row['uid'];
        }
    } else {
        return $pId;
    }
}

function uIDname($uID, $db_link)
{
    $sql = "SELECT `name` FROM `players` WHERE `uid` = '" . $uID . "' ";
    $result_of_query = $db_link->query($sql);
    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            return $row['name'];
        }
    } else {
        return $uID;
    }
}

function IDname($name, $db_link)
{
    $sql = "SELECT `name`,`playerid` FROM `players` WHERE `name` LIKE '%" . $name . "%' ";
    $result_of_query = $db_link->query($sql);

    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_array($result_of_query)) {
        }
    } else {
        return $name;
    }
}

/**
 * @param $text
 */
function message($text)
{
    echo "<br><div class='row'><div class='col-lg-12'>";
    echo "<div class='alert alert-danger alert-dismissable'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<i class='fa fa-info-circle'></i> " . $text . "</div></div></div>";
}

function error($errno, $errstr, $errfile, $errline)
{
    echo '<h4><b>PHP ERROR ' . $errno . '</b> ' . $errstr . ' - ' . $errfile . ':' . $errline . '</h4>';
}

/**
 * @param integer $code
 */
function errorMessage($code, $lang)
{
    switch ($code) {
        case 1:
            return $lang['lowVersion']; //Version too low
        case 2:
            return $lang['dbConnect']; //Db Connection
        case 3:
            return $lang['noRes']; //No Results
        case 4:
            return $lang['404']; //404 Not Found
        case 5:
            return $lang['noPerm']; //No Permissions
        case 6:
            return $lang['banned']; //User Banned
        case 7:
            return $lang['pluginNF']; //Pulgin Not Found
        case 8:
            return $lang['noID']; //No ID
        case 9:
            return $lang['noPlayers']; // RCON no players online
        case 10:
            return $lang['selDB']; // Select A DB
        case 11:
            return $lang['noServer']; // Select A DB
        case 31:
            return $lang['noHouse']; //No House
        case 32:
            return $lang['noVeh']; //No Vehicle
        case 33:
            return $lang['noGang']; //No Gang
        case 34:
            return $lang['noCrimes']; //No Crimes
        case 35:
            return $lang['noCrimes']; //No Crimes
        case 36:
            return $lang['noPlayer']; //No Player
        case 37:
            return $lang['noLic']; //No License
        case 371:
            return $lang['no'] . ' ' . $lang['civil'] . ' ' . $lang['licenses']; //No Civillian Licenses
        case 372:
            return $lang['no'] . ' ' . $lang['medic'] . ' ' . $lang['licenses']; //No Medic Licenses
        case 373:
            return $lang['no'] . ' ' . $lang['police'] . ' ' . $lang['licenses']; //No Police Licenses
        case 38:
            return $lang['no'] . ' ' . $lang['gear']; //No License
        case 381:
            return $lang['no'] . ' ' . $lang['civil'] . ' ' . $lang['gear']; //No Civillian Licenses
        case 382:
            return $lang['no'] . ' ' . $lang['medic'] . ' ' . $lang['gear']; //No Medic Licenses
        case 383:
            return $lang['no'] . ' ' . $lang['police'] . ' ' . $lang['gear']; //No Police Licenses
    }
}

function random($length)
{
    $max = ceil($length / 40);
    $random = '';
    for ($i = 0; $i < $max; $i++) {
        $random .= sha1(microtime(true) . mt_rand(10000, 90000));
    }
    return substr($random, 0, $length);
}

function steamBanned($PID)
{
    $settings = require('config/settings.php');
    if (!empty($settings['steamAPI'])) {
        $api = "http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key=" . $settings['steamAPI'] . "&steamids=" . $PID;
        $bans = json_decode(file_get_contents($api), true);
        if ($bans['players']['0']['VACBanned']) {
            return '<h4><span class="label label-danger" style="margin-left:3px; line-height:2;">VAC BANNED</span></h4>';
        }
        //todo:formatting
    }
}

function tokenGen($length)
{
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

function stripArray($input, $type)
{
    $array = array();

    switch ($type) {
        case 0:
            $array = explode("],[", $input);
            $array = str_replace('"[[', "", $array);
            $array = str_replace(']]"', "", $array);
            $array = str_replace('`', "", $array);
            break;
        case 1:
            $array = explode(",", $input);
            $array = str_replace('"[', "", $array);
            $array = str_replace(']"', "", $array);
            $array = str_replace('`', "", $array);
            break;
        case 2:
            $array = explode(",", $input);
            $array = str_replace('"[', "", $array);
            $array = str_replace(']"', "", $array);
            $array = str_replace('`', "", $array);
            break;
        case 3:
            $input = str_replace('[`', "", $input);
            $input = str_replace('`]', "", $input);
            $array = explode("`,`", $input);
            break;
    }

    return $array;
}

function clean($input, $type)
{
    if ($type == 'string') {
        return filter_var(htmlspecialchars(trim($input)), FILTER_SANITIZE_STRING);
    } elseif ($type == 'int') {
        $input = filter_var(htmlspecialchars(trim($input)), FILTER_SANITIZE_NUMBER_INT);
        if ($input < 0) {
            return 0;
        } else {
            return $input;
        }
    } elseif ($type == 'url') {
        return filter_var(htmlspecialchars(trim($input)), FILTER_SANITIZE_URL);
    } elseif ($type == 'email') {
        return filter_var(htmlspecialchars(trim($input)), FILTER_SANITIZE_EMAIL);
    } elseif ($type == 'boolean') {
        return ($input === 'true');
    } elseif ($type == 'intbool') {
        if ($input == 1 || $input == 0) return $input;
    } else {
        return 0;
    }
}

/**
 * @param string $this
 * @param string|null $inthat
 */
function before($this, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this));
}


/**
 * @param string $this
 */
function after($this, $inthat)
{
    if (!is_bool(strpos($inthat, $this))) {
        return substr($inthat, strpos($inthat, $this) + strlen($this));
    }
}

function communityBanned($GUID)
{
    $settings = require('config/settings.php');
    $data = json_decode(file_get_contents("http://bans.itsyuka.tk/api/bans/player/id/" . $GUID . "/format/json/key/" . $settings['communityBansAPI']), true);

    if ($data['level'] >= 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'x', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}
