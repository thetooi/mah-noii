<?
if (!defined('UC_SYSOP'))
die('Direct access denied.');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<script type="text/javascript" src="java_klappe.js"></script>
<title><?=$SITENAME?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name='description' content='Music Tracker, 0-Day Releases, Free Music Download' />
<meta name='keywords' content='trance house techno electro music torrents free download' />
<META Name="Description" content= "Music Tracker, 0-Day Releases, Free Music Download">
<META Name="Document-state" content ="Dynamic">
<META Name="Keywords" lang="ru" content="trance house techno electro music torrents free download">
<META Name="Keywords" lang="en-us" content="trance house techno electro music torrents free download">
<META Name="Revisit" content="7">
<META name="Robots" content="all">
<META Name="URL" content= "http://www.musicmania.ql.lt">
<link rel="stylesheet" href="pic/musicmania/musicmania.css" type="text/css" charset="utf-8" />
<script language="javascript" type="text/javascript" src="js/resizer.js"></script>
<script language="javascript" type="text/javascript" src="js/spoiler.js"></script>
</head>
<body>
<div id="outer">
  <div id="wrapper">
    <div id="header">
      <h1><?=$SITENAME?></h1>
      <p><?=$TITLE?></p>
    </div>
    <div id="nav">
      <div id="head"></div>
      <div id="head-pip"></div>
      <ul>
      <? if (!$CURUSER) { ?>
      <li id="m1"><a href="index.php">Home</a></li>
        <li id="m2"><a href="login.php">Login</a></li>
        <li id="m3"><a href="signup.php">Signup</a></li>
        <li id="m4"><a href="recover.php">Recover</a></li>
        <li id="m5"><a href="faq.php">Faq</a></li>
        <li id="m6"><a href="rules.php">Rules</a></li>
      <? } else { ?>
        <li id="m1"><a href="index.php">Home</a></li>
        <li id="m2"><a href="browse.php">Browse</a></li>
<?
if (get_user_class() <= UC_PEASANT){ ?>
<li id="m3"><a href="uploadapp.php">Upload</a></li>
<? }
if (get_user_class() <= UC_USER){ ?>
<li id="m3"><a href="uploadapp.php">Upload</a></li>
<? }

?>
<?
if (get_user_class() >= UC_VIP) { ?>
<li id="m3"><a href="upload.php">Upload</a></li>
<? }
?>

        <li id="m4"><a href="forums.php">Forums</a></li>
        <li id="m5"><a href="my.php">Profile</a></li>
        <li id="m6"><a href="staff.php">Staff</a></li>
        <? } ?>
      </ul>
      <div id="search">
        <h2>Search Torrents</h2>
       <form method="get" action=browse.php>
          <input type="text" class="text" name="search" value="<?= htmlspecialchars($searchstr) ?>" id="q" />
          <input type="submit"  value="Search!" id="submit" class="submit" />
        </form>
          <? if (!$CURUSER) { ?>
        <a href="faq.php">Faq</a> | <a href="rules.php">
		Rules</a> | <a href="useragreement.php">
		User agreement</a>| <a href="links.php">
		Links</a></div>
		  <? } else { ?>
		   <a href="faq.php">Faq</a> | <a href="rules.php">
		Rules</a> | <a href="topten.php">
		Top</a>| <a href="links.php">
		Links</a>| <a href="log.php">
		Log</a>| <a href="logout.php">
		logout</a></div><? }
?>
    </div>
    <div id="body">
      <div id="body-inner">
        <div id="body-right">
          </div></div><div align=center>
<?