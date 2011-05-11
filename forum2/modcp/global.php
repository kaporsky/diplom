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

// identify where we are
define('VB_AREA', 'ModCP');
if (!isset($phrasegroups))
{
	$phrasegroups = array();
}
$phrasegroups[] = 'cpglobal';

// ###################### Start functions #######################
chdir('./../');

require_once('./includes/init.php');
require_once('./includes/functions.php');
require_once('./includes/adminfunctions.php');
require_once('./includes/modfunctions.php');
require_once('./includes/functions_calendar.php');
require_once('./includes/sessions.php');

// ###################### Start headers #######################
exec_nocache_headers();

if ($bbuserinfo['cssprefs'] != '')
{
	$vboptions['cpstylefolder'] = $bbuserinfo['cssprefs'];
}


// ###################### Get date / time info #######################
// override date/time settings if specified
fetch_options_overrides($bbuserinfo);
fetch_time_data();

// ############################################ LANGUAGE STUFF ####################################
// initialize $vbphrase and set language constants
$vbphrase = init_language();
$stylevar = fetch_stylevars($_tmp, $bbuserinfo);

$permissions = cache_permissions($bbuserinfo, true);
$bbuserinfo['permissions'] = &$permissions;
$cpsession = array();

if (!empty($_COOKIE[COOKIE_PREFIX . 'cpsession']))
{
	$cpsession = $DB_site->query_first("
		SELECT * FROM " . TABLE_PREFIX . "cpsession
		WHERE userid = $bbuserinfo[userid]
			AND hash = '" . addslashes($_COOKIE[COOKIE_PREFIX . 'cpsession']) . "'
			AND dateline > " . iif($vboptions['timeoutcontrolpanel'], intval(TIMENOW - 3600), intval(TIMENOW - $vboptions['cookietimeout']))
	);

	if (!empty($cpsession))
	{
		$DB_site->shutdown_query("
			UPDATE LOW_PRIORITY " . TABLE_PREFIX . "cpsession
			SET dateline = " . TIMENOW . "
			WHERE userid = $bbuserinfo[userid]
				AND hash = '" . addslashes($_COOKIE[COOKIE_PREFIX . 'cpsession']) . "'
		");
	}
}

if ((!can_moderate() AND !can_moderate_calendar()) OR ($vboptions['timeoutcontrolpanel'] AND !$session['loggedin']) OR empty($_COOKIE[COOKIE_PREFIX . 'cpsession']) OR $_COOKIE[COOKIE_PREFIX . 'cpsession'] != $cpsession['hash'] OR empty($cpsession))
{
	print_cp_login();
}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: global.php,v $ - $Revision: 1.52 $
|| ####################################################################
\*======================================================================*/
?>