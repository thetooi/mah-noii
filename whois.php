<?php
/////////////////////////////////////whois mod ripped and modded by hellix/////////////////////////////////
require_once("include/functions.php");
require_once("include/pprotect.php");
dbconn(false);
loggedinorreturn();
whois($domainName);
parked();
//referer();
if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");
stdhead("Whois");
  if (isset($_GET['domain'])) {
      print whois($_GET['domain']);
  }

  ?>
  <h3>Whois</h3>
  <br />
  <form action="whois.php" method="get">
    <input type="text" name="domain" size="40" value = "<?php print $_GET['domain']; ?>"/>
    <input type="submit" class="groovybutton" value="Get Whois Info" />
  </form>
 <?
 stdfoot();