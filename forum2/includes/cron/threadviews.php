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

error_reporting(E_ALL & ~E_NOTICE);

if (!is_object($DB_site))
{
	exit;
}

$threads = $DB_site->query("SELECT threadid , COUNT(*) AS views FROM " . TABLE_PREFIX . "threadviews GROUP BY threadid");

while ($thread = $DB_site->fetch_array($threads))
{
	$DB_site->query(
		"UPDATE " . TABLE_PREFIX . "thread
		SET views = views + " . intval($thread['views']) . "
		WHERE threadid = " . intval($thread['threadid'])
	);
}

log_cron_action('Thread Views Updated', $nextitem);

$DB_site->query("DELETE FROM " . TABLE_PREFIX . "threadviews");

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: threadviews.php,v $ - $Revision: 1.16 $
|| ####################################################################
\*======================================================================*/
?>