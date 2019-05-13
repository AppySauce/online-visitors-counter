<?php
/*
 * Online Visitors Counter
 *
 * @copyright  Copyright 2014, Victor Nogueira (http://github.com/felladrin)
 * @link       http://github.com/felladrin/online-visitors-counter
 * @license    MIT License (http://opensource.org/licenses/MIT)
 */

require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>
<?php echo $visitorsPageTitle; ?>
</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<style type="text/css">
        body {
            background-color: white;
            text-align: center;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-weight: 300;
            font-size: 15px;
            color: #8dc0e3;
        }

        a {
            text-decoration: none;
            color: #8dc066;
            padding-left: 5px;
        }

        b {
            font-size: 30px;
            color: #8db0e3;
        }
    </style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body>
<div id="Layer1" style="position:absolute; left:-1px; top:-53px; width:224px; height:115px; z-index:1"> 
  <?php
echo "<h3>$visitorsPageTitle</h3>";

try
{
    if (!file_exists($databaseFile))
    {
        $createQuery = "CREATE TABLE 'online' ('id' TEXT PRIMARY KEY NOT NULL, 'page_title' TEXT, 'page_url' TEXT, 'last_activity' INTEGER)";
    }

    $db = new PDO("sqlite:$databaseFile");

    if (isset($createQuery))
    {
        $db->query($createQuery);
    }
}
catch (PDOException $e)
{
    echo $e->getMessage();
}

$result = $db->query('SELECT page_title, page_url, COUNT(page_url) AS count FROM online GROUP BY page_url ORDER BY count DESC');

if ($result)
{
    $result = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $page)
    {
        if (empty($page['page_title']))
        {
            $page['page_title'] = $unknownPages;
        }

        echo "<p><b>$page[count]</b><a href='$page[page_url]' target='_top'>$page[page_title]</a></p>";
    }
}
?>
</div>
<div id="Layer2" style="position:absolute; left:-2px; top:61px; width:224px; height:175px; z-index:2"><img src="http://tapdroid.com/donttrade.png" width="221" height="170"></div>
</body><meta http-equiv="refresh" content="5; url=http://tapdroid.com/trading/ovc" />
</html>
