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

require_once('./includes/functions_digest.php');

// send daily digest of new posts in threads and threads in forums
exec_digest(2);

log_cron_action('Daily Digests Sent', $nextitem);

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: digestdaily.php,v $ - $Revision: 1.11 $
|| ####################################################################
\*======================================================================*/
?>