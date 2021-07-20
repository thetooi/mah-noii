<?php
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');
 // PHP5 with register_long_arrays off?
if (!isset($HTTP_POST_VARS) && isset($_POST))
{
$HTTP_POST_VARS = $_POST;
$HTTP_GET_VARS = $_GET;
$HTTP_SERVER_VARS = $_SERVER;
$HTTP_COOKIE_VARS = $_COOKIE;
$HTTP_ENV_VARS = $_ENV;
$HTTP_POST_FILES = $_FILES;
}

function strip_magic_quotes($arr)
{
foreach ($arr as $k => $v)
{
if (is_array($v))
{ $arr[$k] = strip_magic_quotes($v); }
else
{ $arr[$k] = stripslashes($v); }
}

return $arr;
}

if (get_magic_quotes_gpc())
{
if (!empty($_GET)) { $_GET = strip_magic_quotes($_GET); }
if (!empty($_POST)) { $_POST = strip_magic_quotes($_POST); }
if (!empty($_COOKIE)) { $_COOKIE = strip_magic_quotes($_COOKIE); }
}


// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//

if( !get_magic_quotes_gpc() )
{
if( is_array($HTTP_GET_VARS) )
{
while( list($k, $v) = each($HTTP_GET_VARS) )
{
if( is_array($HTTP_GET_VARS[$k]) )
{
while( list($k2, $v2) = each($HTTP_GET_VARS[$k]) )
{
$HTTP_GET_VARS[$k][$k2] = addslashes($v2);
}
@reset($HTTP_GET_VARS[$k]);
}
else
{
$HTTP_GET_VARS[$k] = addslashes($v);
}
}
@reset($HTTP_GET_VARS);
}

if( is_array($HTTP_POST_VARS) )
{
while( list($k, $v) = each($HTTP_POST_VARS) )
{
if( is_array($HTTP_POST_VARS[$k]) )
{
while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
{
$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
}
@reset($HTTP_POST_VARS[$k]);
}
else
{
$HTTP_POST_VARS[$k] = addslashes($v);
}
}
@reset($HTTP_POST_VARS);
}

if( is_array($HTTP_COOKIE_VARS) )
{
while( list($k, $v) = each($HTTP_COOKIE_VARS) )
{
if( is_array($HTTP_COOKIE_VARS[$k]) )
{
while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
{
$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
}
@reset($HTTP_COOKIE_VARS[$k]);
}
else
{
$HTTP_COOKIE_VARS[$k] = addslashes($v);
}
}
@reset($HTTP_COOKIE_VARS);
}
}
function local_user()
{
  return $_SERVER["SERVER_ADDR"] == $_SERVER["REMOTE_ADDR"];
}
//$FUNDS = "$2,610.31";

$SITE_ONLINE = true;
// Site closed for coding/fixing (0 or false = no; 1 or true = yes)
$SYSOP_TESTING = 1;

$max_torrent_size = 1000000;
$announce_interval = 60 * 30;
$signup_timeout = 86400 * 3;
$minvotes = 1;
$max_dead_torrent_time = 6 * 3600;
$table_cat = "categories";
// Max users on site
$maxusers = 75000; // LoL Who we kiddin' here?
$invites = 3000;
// Max users on site
$maxusers = 5000;

// ONLY USE ONE OF THE FOLLOWING DEPENDING ON YOUR O/S!!!
$torrent_dir = "/home/yoursite/domains/yoursite.com/public_html/torrents";    # FOR UNIX ONLY - must be writable for httpd user
//$torrent_dir = "C:/web/Apache2/htdocs/tbsource/torrents";    # FOR WINDOWS ONLY - must be writable for httpd user

# the first one will be displayed on the pages
$announce_urls = array();
$announce_urls[] = "http://www.yoursite.com/announce.php";
$announce_urls[] = "http://domain.com:82/announce.php";
$announce_urls[] = "http://domain.com:83/announce.php";

if ($_SERVER["HTTP_HOST"] == "")                        // Root Based Installs Comment Out if in Sub-Dir
  $_SERVER["HTTP_HOST"] = $_SERVER["SERVER_NAME"];      // Comment out for Sub-Dir Installs
$BASEURL = "http://" . $_SERVER["HTTP_HOST"];           // Comment out for Sub-Dir Installs

//$BASEURL = 'http://domain.com';                       // Uncomment for Sub-Dir Installs - No Ending Slash

// Set this to your site URL... No ending slash!
$DEFAULTBASEURL = "http://www.yoursite.com";

//set this to true to make this a tracker that only registered users may use
$MEMBERSONLY = true;

//maximum number of peers (seeders+leechers) allowed before torrents starts to be deleted to make room...
//set this to something high if you don't require this feature
$PEERLIMIT = 50000;

// Email for sender/return path.
$SITEEMAIL = "yoursite@noreply.com";

$SITENAME = "Yoursite";
$TITLE = "Demo site";

//Directory for cache
$CACHE = "/home/yoursite/domains/yoursite.com/public_html/cache"; # FOR UNIX ONLY - must be writable for httpd user
//$cache = "C:/Server/www/cache"; // for windows
$autoclean_interval = 900;
$pic_base_url = "/pic/";

$maxloginattempts = 3; // change this whatever u want. if u dont know what is this, leave it default
//Do not modify -- versioning system
//This will help identify code for support issues at tbdev.net
define ('TBVERSION','TBDEV.NET-12-09-05');
// Page protect conf start
$LOGIN_INFORMATION = array(
  'admin' => 'password'  ///username  => password
);

// request login? true - show login and password boxes, false - password box only
define('USE_USERNAME', true);

// time out after NN minutes of inactivity. Set to 0 to not timeout
define('TIMEOUT_MINUTES', 3);

// This parameter is only useful when TIMEOUT_MINUTES is not zero
// true - timeout time from last activity, false - timeout time from login
define('TIMEOUT_CHECK_ACTIVITY', true);

// Page protect conf end

// PM special folder IDs
define (PM_FOLDERID_INBOX, -1);
define (PM_FOLDERID_OUTBOX, -2);
define (PM_FOLDERID_SYSTEM, -3);
define (PM_FOLDERID_MOD, -4);

$GLOBALS["PM_PRUNE_DAYS"] = 10;
?>