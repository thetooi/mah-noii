<?
require "include/functions.php";
dbconn();
loggedinorreturn();
parked();
//referer();
$res = mysql_query("SELECT id, name FROM categories ORDER BY name");
while($cat = mysql_fetch_assoc($res))
        $catoptions .= "<input type=\"checkbox\" name=\"cat[]\" value=\"$cat[id]\" " .
            (strpos($CURUSER['notifs'], "[cat$cat[id]]") !== false ? " checked" : "") .
            "/>$cat[name]<br>";
//        $category[$cat['id']] = $cat['name'];

    stdhead("RSS Feed");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $link = "$BASEURL/rss.php";
        if ($_POST['feed'] == "dl")
            $query[] = "feed=dl";
        foreach($_POST['cat'] as $cat)
            $query[] = "cat[]=$cat";
        if ($_POST['login'] == "passkey")
            $query[] = "passkey=$CURUSER[passkey]";
        $queries = implode("&", $query);
        if ($queries)
            $link .= "?$queries";
        print("Use the following url in your RSS reader:<br><b>$link</b><br>");
        die();
    }
?>

<form method="POST" action="getrss.php">
    <table>
        <tr>
            <td class="rowhead">Categories to retrieve:</td>
            <td><?=$catoptions?></td>
        </tr>
        <tr>
            <td class="rowhead">Feed type:</td>
            <td><input type="radio" name="feed" value="web" />Web link<br>
                <input type="radio" name="feed" value="dl" />Download link</td>
        </tr>
        <tr>
            <td class="rowhead">Login type:</td>
            <td><input type="radio" name="login" value="cookie" />Standard (cookies)<br>
                <input type="radio" name="login" value="passkey" />Alternative (no cookies)</td>
        </tr>
    </table>
    <button type="submit">Generate RSS link</button>
</form>

<?
   /* stdfoot();*/
?>