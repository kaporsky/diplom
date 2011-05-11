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

// display the credits table for use in admin/mod control panels

print_form_header('index', 'home');
print_table_header($vbphrase['vbulletin_developers_and_contributors']);
print_column_style_code(array('white-space: nowrap', ''));
print_label_row('<b>'.$vbphrase['software_developed_by'].'</b>', '
	Jelsoft Enterprises Limited
', '', 'top', NULL, false);
print_label_row('<b>'.$vbphrase['product_manager'].'</b>', '
	Kier Darby,
	John Percival
', '', 'top', NULL, false);
print_label_row('<b>'.$vbphrase['business_development'].'</b>', '
	<James Limm,
	Ashley Busby
', '', 'top', NULL, false);
print_label_row('<b>'.$vbphrase['software_development'].'</b>', '
	Kier Darby,
	Freddie Bingham,
	Scott MacVicar,
	Mike Sullivan,
	Jerry Hutchings
', '', 'top', NULL, false);
print_label_row('<b>'.$vbphrase['graphics_development'].'</b>', '
	Kier Darby,
	Fabio Passaro
', '', 'top', NULL, false);
print_label_row('<b>'.$vbphrase['other_contributions_from'].'</b>', '
	Jake Bunce,
	Doron Rosenberg,
	Overgrow,
	Kevin Schumacher,
	Chen Avinadav,
	Floris Fiedeldij Dop,
	Stephan Pogodalla,
	Michael König,
	Torstein Hønsi
', '', 'top', NULL, false);
print_table_footer();


/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: vbulletin_credits.php,v $ - $Revision: 1.22.2.2 $
|| ####################################################################
\*======================================================================*/
?>