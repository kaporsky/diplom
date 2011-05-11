<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.0.7
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000–2005 Jelsoft Enterprises Ltd. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| ############################[DGT-TEAM]############################## ||
\*======================================================================*/

// ####################### SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('NO_REGISTER_GLOBALS', 1);
define('SESSION_BYPASS', 1);
define('LOCATION_BYPASS', 1);
define('DIE_QUIETLY', 1);
define('THIS_SCRIPT', 'external');

// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array();

// get special data templates from the datastore
$specialtemplates = array(
	'userstats',
	'birthdays',
	'maxloggedin'
);

// pre-cache templates used by all actions
$globaltemplates = array();

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once('./includes/functions_external.php');

// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

// set us up as a very limited privileges user
$vboptions['hourdiff'] = (date('Z', TIMENOW) / 3600 - intval($_REQUEST['timeoffset'])) * 3600;
$bbuserinfo = array('usergroupid' => 1);
$usergroupcache = array();
$permissions = cache_permissions($bbuserinfo);

// check to see if there is a forum preference
if ($_REQUEST['forumids'] != '')
{
	$forumchoice = array();
	$forumids = explode(',', $_REQUEST['forumids']);
	foreach ($forumids AS $forumid)
	{
		$forumid = intval($forumid);
		$fp = &$bbuserinfo['forumpermissions']["$forumid"];
		if (isset($forumcache["$forumid"]) AND ($fp & CANVIEW) AND ($fp & CANVIEWOTHERS) AND verify_forum_password($forumid, $forumcache["$forumid"]['password'], false))
		{
			$forumchoice[] = $forumid;
		}
	}

	$number_of_forums = sizeof($forumchoice);
	if ($number_of_forums == 1)
	{
		$title = $forumcache["$forumchoice[0]"]['title'];
	}
	else if ($number_of_forums > 1)
	{
		$title = implode(',', $forumchoice);
	}
	else
	{
		$title = '';
	}

	if (!empty($forumchoice))
	{
		$forumchoice = 'AND thread.forumid IN(' . implode(',', $forumchoice) . ')';
	}
	else
	{
		$forumchoice = '';
	}
}
else
{
	foreach (array_keys($forumcache) AS $forumid)
	{
		$fp = &$bbuserinfo['forumpermissions']["$forumid"];
		if (($fp & CANVIEW) AND ($fp & CANVIEWOTHERS) AND verify_forum_password($forumid, $forumcache["$forumid"]['password'], false))
		{
			$forumchoice[] = $forumid;
		}
	}
	if (!empty($forumchoice))
	{
		$forumchoice = 'AND thread.forumid IN(' . implode(',', $forumchoice) . ')';
	}
	else
	{
		$forumchoice = '';
	}
}

if ($forumchoice != '')
{
	// query last 15 threads from visible / chosen forums
	$threads = $DB_site->query("
		SELECT thread.threadid, thread.title, thread.lastposter, thread.lastpost, thread.postusername, thread.dateline, forum.forumid, forum.title AS forumtitle, post.pagetext AS preview
		FROM " . TABLE_PREFIX . "thread AS thread
		INNER JOIN " . TABLE_PREFIX . "forum AS forum ON(forum.forumid = thread.forumid)
		LEFT JOIN " . TABLE_PREFIX . "post AS post ON (post.postid = thread.firstpostid)
		LEFT JOIN " . TABLE_PREFIX . "deletionlog AS deletionlog ON (deletionlog.primaryid = thread.threadid AND deletionlog.type = 'thread')
		WHERE 1=1
			$forumchoice
			AND thread.visible = 1
			AND open <> 10
			AND deletionlog.primaryid IS NULL
		ORDER BY thread.dateline DESC
		LIMIT 15
	");
}

$threadcache = array();
while ($thread = $DB_site->fetch_array($threads))
{ // fetch the threads
	$threadcache[] = $thread;
}
$_REQUEST['type'] = strtoupper($_REQUEST['type']);
switch ($_REQUEST['type'])
{
	case 'JS':
	case 'XML':
	case 'RSS2':
		break;
	default:
		$_REQUEST['type'] = 'RSS';
}

if ($_REQUEST['type'] == 'JS' AND $vboptions['externaljs'])
{ // javascript output

	?>
	function thread(threadid, title, poster, threaddate, threadtime)
	{
		this.threadid = threadid;
		this.title = title;
		this.poster = poster;
		this.threaddate = threaddate;
		this.threadtime = threadtime;
	}
	<?php
	echo "var threads = new Array(" . sizeof ($threadcache) . ");\r\n";
	if (!empty($threadcache))
	{
		foreach ($threadcache AS $threadnum => $thread)
		{
			$thread['title'] = addslashes_js($thread['title']);
			$thread['poster'] = addslashes_js($thread['postusername']);
			echo "\tthreads[$threadnum] = new thread($thread[threadid], '$thread[title]', '$thread[poster]', '" . vbdate($vboptions['dateformat'], $thread['dateline']) . "', '" . vbdate($vboptions['timeformat'], $thread['dateline']) . "');\r\n";
		}
	}

}
else if ($_REQUEST['type'] == 'XML' AND $vboptions['externalxml'])
{ // XML output

	// set XML type and nocache headers
	header('Content-Type: text/xml');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	// print out the page header
	echo '<?xml version="1.0" encoding="' . $stylevar['charset'] . '"?>' . "\r\n";
	echo "<source>\r\n\r\n";
	echo "\t<url>$vboptions[bburl]</url>\r\n\r\n";

	// list returned threads
	if (!empty($threadcache))
	{
		foreach ($threadcache AS $thread)
		{
			echo "\t<thread id=\"$thread[threadid]\">\r\n";
			echo "\t\t<title><![CDATA[$thread[title]]]></title>\r\n";
			echo "\t\t<author><![CDATA[$thread[postusername]]]></author>\r\n";
			echo "\t\t<date>" . vbdate($vboptions['dateformat'], $thread['dateline']) . "</date>\r\n";
			echo "\t\t<time>" . vbdate($vboptions['timeformat'], $thread['dateline']) . "</time>\r\n";
			echo "\t</thread>\r\n";
		}
	}
	echo "\r\n</source>";
}
else if (($_REQUEST['type'] == 'RSS' OR $_REQUEST['type'] == 'RSS2') AND $vboptions['externalrss'])
{ // RSS output
	// setup the board title
	if (empty($title))
	{ // just show board title
		$rss_title = htmlspecialchars_uni($vboptions['bbtitle']);
	}
	else
	{ // show board title plus selection
		$rss_title = htmlspecialchars_uni($vboptions['bbtitle'] . " - $title");
	}
	if ($_REQUEST['type'] == 'RSS2')
	{
		$v = 2;
	}
	else
	{
		$v = 1;
	}
	// set XML type and nocache headers
	header('Content-Type: text/xml');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	echo '<?xml version="1.0" encoding="' . $stylevar['charset'] . '"?>' . "\r\n";
	if ($v == 2)
	{
		echo "<rss version=\"2.0\"
\txmlns:dc=\"http://purl.org/dc/elements/1.1/\"
\txmlns:syn=\"http://purl.org/rss/1.0/modules/syndication/\"
\txmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
\txmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\r\n\r\n";
	}
	else
	{
		echo '<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://my.netscape.com/publish/formats/rss-0.91.dtd">' . "\r\n";
		echo '<rss version="0.91">' . "\r\n";
	}
	echo "<channel>\r\n";
	echo "\t<title>" . $rss_title . "</title>\r\n";
	echo "\t<link>$vboptions[bburl]</link>\r\n";
	echo "\t<description>" . htmlspecialchars_uni($vboptions['description']) . "</description>\r\n";

	if ($v == 2)
	{
	echo "\t<syn:updatePeriod>hourly</syn:updatePeriod>\r\n";
	echo "\t<syn:updateFrequency>1</syn:updateFrequency>\r\n";
	echo "\t<syn:updateBase>1970-01-01T00:00+00:00</syn:updateBase>\r\n";
	echo "\t<dc:language>$stylevar[languagecode]</dc:language>\r\n";
	echo "\t<dc:creator>vBulletin</dc:creator>\r\n";
	$tz = vbdate('O', TIMENOW);
	if ($tz == '+0000')
	{
		$tz = 'Z';
	}
	else
	{
		$tz = substr($tz, 0, 3) . ':' . substr($tz, 3, 2);
	}
	echo "\t<dc:date>" . vbdate('Y-m-d\TH:i:s', TIMENOW) . "$tz</dc:date>\r\n";
	}

	#	<image>
	#		<title>< ?php echo $vboptions['bbtitle']; ? ></title>
	#		<url>http://www.domain.com/images/image.gif</url>
	#		<link>< ?php echo $vboptions['bburl']; ? ></link>
	#	</image>

	$i = 0;

	// list returned threads
	if (!empty($threadcache))
	{
		foreach ($threadcache AS $thread)
		{
			$fp = &$bbuserinfo['forumpermissions']["$forumid"];

			echo "\t<item>\r\n";
			echo "\t\t<title>$thread[title]</title>\r\n";
			echo "\t\t<link>$vboptions[bburl]/showthread.php?t=$thread[threadid]&amp;goto=newpost</link>\r\n";
			if ($v == 1)
			{
				echo "\t\t<description><![CDATA[$vbphrase[forum]: " . htmlspecialchars_uni($thread['forumtitle']) . "\r\n$vbphrase[posted_by]: $thread[postusername]\r\n" .
					construct_phrase($vbphrase['post_time_x_at_y'], vbdate($vboptions['dateformat'], $thread['dateline']), vbdate($vboptions['timeformat'], $thread['dateline'])) .
					"]]></description>\r\n";
			}
			else
			{ // RSS v2 allows more data
				echo "\t\t<content:encoded><![CDATA[". htmlspecialchars_uni(fetch_trimmed_title(strip_bbcode($thread['preview'], false, true), $vboptions['threadpreview'])) ."]]></content:encoded>\r\n";
				echo "\t\t<guid isPermaLink=\"false\">$vboptions[bburl]/showthread.php?t=$thread[threadid]</guid>\r\n";
				// cant use the $tz value for TIMENOW as DST could have been in effect when this post was made.
				$tz = vbdate('O', $thread['dateline']);
				if ($tz == '+0000')
				{
					$tz = 'Z';
				}
				else
				{
					$tz = substr($tz, 0, 3) . ':' . substr($tz, 3, 2);
				}
				echo "\t\t<dc:date>" . vbdate('Y-m-d\TH:i:s', $thread['dateline']) . "$tz</dc:date>\r\n";
				echo "\t\t<dc:creator>$thread[postusername]</dc:creator>\r\n";
			}
			echo "\t</item>\r\n";
		}
	}
	echo "</channel>\r\n";
	echo "</rss>";

}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: external.php,v $ - $Revision: 1.53.2.1 $
|| ####################################################################
\*======================================================================*/
?>