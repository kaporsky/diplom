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

// ###################### Start checkanncperms #######################
function can_announce($forumid)
{
	global $DB_site, $permissions;
	if (!($permissions['adminpermissions'] & CANCONTROLPANEL))
	{
		if ($forumid == -1 AND !($permissions['adminpermissions'] & ISMODERATOR))
		{
			return 1;
		}
		else if ($forumid != -1 AND !can_moderate($forumid, 'canannounce'))
		{
			return 2;
		}
	}

	return 0;
}

// ###################### Start transAnncPermError #######################
function fetch_announcement_permissions_error($errno)
{
	global $vbphrase;
	switch($errno)
	{
		case 1:
			return 'you_do_not_have_permission_global';
			break;
		case 2:
			return 'you_do_not_have_permission_forum';
			break;
		default:
			return construct_phrase($vbphrase['unknown_error'], $errno);
	}
}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: adminfunctions_announcement.php,v $ - $Revision: 1.18 $
|| ####################################################################
\*======================================================================*/
?>