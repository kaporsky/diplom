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

define('NO_REGISTER_GLOBALS', 1);
define('SESSION_BYPASS', 1);

$phrasegroups = array();
$specialtemplates = array();

chdir('./../');
require_once('./includes/init.php');
require_once('./includes/adminfunctions.php');
require_once('./includes/functions_subscriptions.php');

if ($_REQUEST['callbackPW'] == $worldpay_password)
{

	$item_number = explode('_', $_REQUEST['desc']);
	$subscriptionid = intval($item_number[0]);

	if (empty($item_number[1]))
	{ // non vBulletin subscription
		exit;
	}

	$userid = $DB_site->query_first("SELECT userid FROM " . TABLE_PREFIX . "user WHERE userid = " . intval($item_number[1]));
	if ($subscriptionid AND $userid['userid'])
	{
		$sub = $DB_site->query_first("SELECT * FROM " . TABLE_PREFIX . "subscription WHERE subscriptionid = $subscriptionid");
		if ($_REQUEST['transStatus'] == 'Y' AND ($_REQUEST['authMode'] == 'A' OR $_REQUEST['authMode'] == 'O'))
		{
			$cost = unserialize($sub['cost']);
			if ($_REQUEST['cost'] == $cost[strtolower($_REQUEST['currency'])])
			{
				build_user_subscription($subscriptionid, $userid['userid']);
			}
		}
	}

}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: worldpay.php,v $ - $Revision: 1.1 $
|| ####################################################################
\*======================================================================*/
?>