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

$attachments = $DB_site->query("SELECT attachmentid, COUNT(*) AS views FROM " . TABLE_PREFIX . "attachmentviews GROUP BY attachmentid");

while ($attachment = $DB_site->fetch_array($attachments))
{
	$DB_site->query("UPDATE " . TABLE_PREFIX . "attachment SET counter = counter + $attachment[views] WHERE attachmentid = $attachment[attachmentid]");
}

log_cron_action('Attachment Views Updated', $nextitem);

$DB_site->query("DELETE FROM " . TABLE_PREFIX . "attachmentviews");

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: attachmentviews.php,v $ - $Revision: 1.11 $
|| ####################################################################
\*======================================================================*/
?>