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

// ###################### Start reputationrecur #######################
function fetch_event_recurrence_sql($reputation)
{
	static $count;
	$count++;

	if ($count == sizeof($reputation))
	{ // last item
		// if we make it to the end than either the reputation is greather than our greatest value or it is less than our least value
		return 'IF (reputation >= ' . $reputation[$count]['value'] . ', ' . $reputation[$count]['index'] . ', ' . $reputation[1]['index'] . ')';
	}
	else
	{
		return 'IF (reputation >= ' . $reputation[$count]['value'] . ' AND reputation < ' . $reputation[($count + 1)]['value'] . ', ' . $reputation[$count]['index']. ',' . fetch_event_recurrence_sql($reputation) . ')';
	}
}

// ###################### Start updatereputationids #######################
function build_reputationids()
{
	global $DB_site;

	$count = 1;
	$reputations = $DB_site->query("
		SELECT reputationlevelid, minimumreputation
		FROM " . TABLE_PREFIX . "reputationlevel
		ORDER BY minimumreputation
	");
	while ($reputation = $DB_site->fetch_array($reputations))
	{
		$ourreputation[$count]['value'] = $reputation['minimumreputation'];
		$ourreputation[$count]['index'] = $reputation['reputationlevelid'];
		$count++;
	}
	if ($count > 1)
	{
		$sql = fetch_event_recurrence_sql($ourreputation);
		$DB_site->query("
			UPDATE " . TABLE_PREFIX . "user
			SET reputationlevelid = $sql
		");

	}
	else
	{
		// it seems we have deleted all of our reputation levels??
		$DB_site->query("
			UPDATE " . TABLE_PREFIX . "user
			SET reputationlevelid = 0
		");
	}
}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: adminfunctions_reputation.php,v $ - $Revision: 1.2 $
|| ####################################################################
\*======================================================================*/
?>